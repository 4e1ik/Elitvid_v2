<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class UrnRepository
{
    public function active(): Collection
    {
        return Product::query()
            ->where('product_type', 'urn')
            ->where('active', 1)
            ->with(['images', 'urn'])
            ->latest()
            ->get();
    }

    public function findBySlug(string $slug): ?Product
    {
        return Product::query()
            ->where('product_type', 'urn')
            ->where('slug', $slug)
            ->where('active', 1)
            ->has('urn')
            ->with(['images', 'urn'])
            ->first();
    }

    public function random(): Collection
    {
        return Product::query()
            ->where('product_type', 'urn')
            ->where('active', 1)
            ->with(['images'])
            ->inRandomOrder()
            ->get();
    }
}
