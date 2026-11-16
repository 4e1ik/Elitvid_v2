<?php

namespace App\Repositories;

use App\DTO\OrderFilterData;
use App\DTO\PlaceOrderData;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class OrderRepository
{
    public function create(PlaceOrderData $data, array $lines): Order
    {
        return DB::transaction(function () use ($data, $lines) {
            $order = Order::query()->create([
                'name' => $data->name,
                'email' => $data->email,
                'phone' => $data->phone,
                'corporation_name' => $data->corporationName,
                'comment' => $data->comment,
            ]);
            $order->items()->createMany($lines);

            return $order->load('items');
        });
    }

    public function matching(OrderFilterData $filter): Builder
    {
        return Order::query()
            ->with('items')
            ->when($filter->from, function (Builder $query) use ($filter) {
                $query->whereDate('created_at', '>=', $filter->from);
            })
            ->when($filter->to, function (Builder $query) use ($filter) {
                $query->whereDate('created_at', '<=', $filter->to);
            })
            ->latest();
    }
}
