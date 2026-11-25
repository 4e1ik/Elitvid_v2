<?php

namespace App\Helpers;

use App\Models\Product;

final class ProductRouteCreatingHelper
{
    public function route(Product $product): string
    {
        $type = $product->product_type;

        if ($type === 'urn') {
            return route('admin_urns');
        }

        $routes = [
            'pot' => [
                'Square_rectangular' => route('admin_square_rectangular_pots'),
                'Round' => route('admin_round_pots'),
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
