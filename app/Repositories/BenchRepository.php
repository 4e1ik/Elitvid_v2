<?php

namespace App\Repositories;

use App\Models\Product;

class BenchRepository
{
    public function collectionOf(string $slug): ?string
    {
        return Product::query()
            ->where('slug', $slug)
            ->where('product_type', 'bench')
            ->with('bench')
            ->first()
            ?->bench
            ?->collection;
    }
}
