<?php

namespace App\Helpers;

use App\Models\Product;

final class ProductRouteCreatingHelper
{
    public function route(Product $product): string
    {
        $type = $product->product_type;

        $routes = [
            'pot' => [
                'Square' => route('admin_square_pots'),
                'Round' => route('admin_round_pots'),
                'Rectangular' => route('admin_rectangular_pots'),
            ],
            'bench' => [
                'Verona' => route('admin_benches_verona'),
                'Stones' => route('admin_benches_stones'),
                'lines' => route('admin_benches_solo'),
                'Solo' => route('admin_benches_lines'),
                'Street_furniture' => route('admin_benches_street_furniture'),
            ]
        ];

        return $routes[$type][$product->{$type}->collection];
    }
}
