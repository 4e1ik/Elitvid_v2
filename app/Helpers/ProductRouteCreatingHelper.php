<?php

namespace App\Helpers;

final class ProductRouteCreatingHelper
{
    public function route(string $productType)
    {
        return match($productType) {
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
            ],
            default => [],
        };
    }
}
