<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateProductRequest;
use App\Models\Bench;
use App\Models\Pot;
use App\Models\PotImage;
use App\Models\PotProduct;
use App\Models\Product;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class ProductController
{
    public function __construct(
        public ImageService $imageService,
    ){}

    public function store(CreateProductRequest $request)
    {
        $data = $request->all();
//        dd($data);

        $product = Product::create($data);

        $data['product_id'] = $product->id;

        switch ($data['product_type']) {
            case 'bench':
                Bench::create($data);

                $routes = [
                    'Verona' => route('admin_benches_verona'),
                    'Stones' => route('admin_benches_stones'),
                    'lines' => route('admin_benches_solo'),
                    'Solo' => route('admin_benches_lines'),
                    'Street_furniture' => route('admin_benches_street_furniture'),
                ];
                break;

            case 'fitting':
                Pot::create($data);

                $routes = [
                    'Square' => route('admin_square_pots'),
                    'Round' => route('admin_round_pots'),
                    'Rectangular' => route('admin_rectangular_pots'),
                ];
                break;
        }

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $this->imageService->save(file: $file, model: $product);
            }
        }

        $collection = $data['collection'];


        return redirect($routes[$collection]);
    }
}
