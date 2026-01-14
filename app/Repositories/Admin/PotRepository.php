<?php

namespace App\Repositories\Admin;

use App\Models\Product;

class PotRepository
{
    public function getPots(string $collection)
    {
        $products = Product::where('active', true)
            ->with('pot')
            ->latest()
            ->get()
            ->filter(function ($query) use ($collection) {
                if ($query->pot->collection === $collection) return $query;
            });

        return $products;
    }
}
