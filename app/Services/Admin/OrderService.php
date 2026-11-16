<?php

namespace App\Services\Admin;

use App\DTO\OrderFilterData;
use App\Repositories\OrderRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class OrderService
{
    public function __construct(
        public OrderRepository $orders,
    ) {}

    public function page(OrderFilterData $filter): LengthAwarePaginator
    {
        return $this->orders->matching($filter)->paginate(20)->withQueryString();
    }

    public function csv(OrderFilterData $filter): string
    {
        $handle = fopen('php://temp', 'r+');
        fwrite($handle, "\xEF\xBB\xBF");
        fputcsv($handle, ['Дата', 'Имя', 'Почта', 'Телефон', 'Организация', 'Комментарий', 'Товары'], ';');

        foreach ($this->orders->matching($filter)->get() as $order) {
            $products = $order->items
                ->map(fn ($item) => $item->product_name.' × '.$item->quantity)
                ->implode('; ');

            fputcsv($handle, [
                $order->created_at ? $order->created_at->format('d.m.Y H:i') : '',
                $order->name,
                $order->email,
                $order->phone,
                $order->corporation_name ?? '',
                $order->comment ?? '',
                $products,
            ], ';');
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return $csv === false ? '' : $csv;
    }
}
