<?php

namespace App\Services;

use App\DTO\PlaceOrderData;
use App\Mail\OrderMail;
use App\Models\Order;
use App\Models\Product;
use App\Repositories\CartRepository;
use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class CartService
{
    public function __construct(
        public CartRepository $carts,
        public OrderRepository $orders,
    ) {}

    public function lines(): array
    {
        $items = $this->carts->all();
        if ($items === []) {
            return [];
        }

        $products = Product::query()
            ->whereIn('id', array_keys($items))
            ->get()
            ->keyBy('id');

        $lines = [];
        foreach (array_keys($items) as $id) {
            $product = $products->get($id);
            $available = $product
                && $product->active
                && $product->deleted_at === null
                && in_array($product->product_type, ['bench', 'pot', 'urn'], true);

            $lines[] = [
                'product_id' => (int) $id,
                'name' => $available ? $product->name : 'Товар недоступен',
                'available' => $available,
            ];
        }

        return $lines;
    }

    public function has(int $productId): bool
    {
        return array_key_exists($productId, $this->carts->all());
    }

    public function add(int $productId): void
    {
        $items = $this->carts->all();
        // количество в корзине не ведём: товар либо есть, либо нет
        $items[$productId] = 1;
        $this->carts->save($items);
    }

    public function changeQuantity(int $productId, int $quantity): void
    {
        $items = $this->carts->all();
        if (!array_key_exists($productId, $items)) {
            return;
        }

        if ($quantity < 1) {
            unset($items[$productId]);
        } else {
            $items[$productId] = $quantity;
        }

        $this->carts->save($items);
    }

    public function clear(): void
    {
        $this->carts->save([]);
    }

    public function place(PlaceOrderData $data): Order
    {
        $lines = $this->lines();
        if ($lines === []) {
            throw ValidationException::withMessages([
                'cart' => 'Корзина пуста.',
            ]);
        }

        foreach ($lines as $line) {
            if (!$line['available']) {
                throw ValidationException::withMessages([
                    'cart' => 'В корзине есть недоступный товар. Уберите его и отправьте заявку снова.',
                ]);
            }
        }

        $stored = [];
        foreach ($lines as $line) {
            $stored[] = [
                'product_id' => $line['product_id'],
                'product_name' => $line['name'],
                'quantity' => 1,
            ];
        }

        $order = $this->orders->create($data, $stored);
        $products = $order->items
            ->pluck('product_name')
            ->implode('; ');

        Log::info(sprintf(
            'Сформирован заказ #%d. Имя: %s. Почта: %s. Телефон: %s. Организация: %s. Комментарий: %s. Товары: %s',
            $order->id,
            $order->name,
            $order->email,
            $order->phone,
            $order->corporation_name ?: '—',
            $order->comment ?: '—',
            $products
        ));

        try {
            // тот же адрес заявок, что в MailController::send — менять в обоих местах
            Mail::to('el_vid@mail.ru')->send(new OrderMail($order));
        } catch (\Throwable $e) {
            // заказ уже сохранён: сбой почты не должен его терять
            Log::error(sprintf('Письмо по заказу #%d не отправлено: %s', $order->id, $e->getMessage()));
            $this->orders->markMailFailed($order);
        }

        $this->clear();

        return $order;
    }
}
