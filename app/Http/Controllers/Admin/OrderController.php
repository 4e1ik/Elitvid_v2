<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderFilterRequest;
use App\Services\Admin\OrderService;

class OrderController extends Controller
{
    public function __construct(
        public OrderService $orderService,
    ) {}

    public function index(OrderFilterRequest $request)
    {
        $filter = $request->toData();
        $orders = $this->orderService->page($filter);

        return view('elitvid.admin.orders.index', compact('orders', 'filter'));
    }

    public function export(OrderFilterRequest $request)
    {
        $csv = $this->orderService->csv($request->toData());

        return response($csv, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="orders.csv"',
        ]);
    }
}
