<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\PlaceOrderRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Services\CartService;

class CartController extends Controller
{
    public function __construct(
        public CartService $cartService,
    ) {}

    public function show()
    {
        $lines = $this->cartService->lines();

        return view('elitvid.site.cart', [
            'lines' => $lines,
            'canOrder' => $lines !== [] && collect($lines)->every(fn ($line) => $line['available']),
        ]);
    }

    public function add(AddToCartRequest $request)
    {
        $this->cartService->add((int) $request->validated('product_id'));

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Товар добавлен в корзину.',
            ]);
        }

        return back();
    }

    public function update(UpdateCartRequest $request, int $product)
    {
        $this->cartService->changeQuantity($product, (int) $request->validated('quantity'));

        return redirect()->route('cart.show');
    }

    public function clear()
    {
        $this->cartService->clear();

        return redirect()->route('cart.show')->with('success', 'Корзина очищена.');
    }

    public function place(PlaceOrderRequest $request)
    {
        $this->cartService->place($request->toData());

        return redirect()->route('cart.show')->with('success', 'Заявка принята.');
    }
}
