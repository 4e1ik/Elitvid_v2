<?php

namespace App\Repositories\Admin;

use App\Models\Product;

class BenchRepository
{
    public function getBenches(string $collection)
    {
        $products = Product::whereHas('bench', function ($query) use ($collection) {
                $query->where('collection', $collection);
            })
            ->with('bench')
            ->latest()
            ->get();

        return $products;
    }
}
