<?php

namespace App\Repositories\Admin;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class UrnRepository
{
    public function all(): Collection
    {
        return Product::query()
            ->where('product_type', 'urn')
            ->with('urn')
            ->latest()
            ->get();
    }
}
