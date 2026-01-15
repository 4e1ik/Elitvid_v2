<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Bench;
use App\Models\Pot;
use App\Models\Product;
use App\Services\ImageService;

class ProductController
{
    public function __construct(
        public ImageService $imageService,
    ){}

    public function store(CreateProductRequest $request)
    {
        $data = $request->all();

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

            case 'pot':
                Pot::create($data);

                $routes = [
                    'Square' => route('admin_square_pots'),
                    'Round' => route('admin_round_pots'),
                    'Rectangular' => route('admin_rectangular_pots'),
                ];
                break;
        }

        if ($request->hasFile('image')) {
            $images = $request->file('image');
            $imageData = $request->input('image_data', []);

            // Если это одно изображение (скамейка), преобразуем в массив
            if (!is_array($images)) {
                $images = [$images];
                $imageData = [$imageData];
            }

            foreach ($images as $index => $file) {
                $imageDataForFile = $imageData[$index] ?? [];

                $this->imageService->save(
                    file: $file,
                    model: $product,
                    data: $imageDataForFile
                );
            }
        }

        $collection = $data['collection'];


        return redirect($routes[$collection]);
    }

    public function edit(Product $product)
    {
        $product->load(['pot', 'bench', 'images']);

        // Определяем тип продукта
        $productType = $product->pot ? 'pot' : ($product->bench ? 'bench' : null);

        if (!$productType) {
            abort(404, 'Тип продукта не определен');
        }

        return view('includes.elitvid.admin.update_product', compact('product', 'productType'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->all();

        // Обновляем продукт
        $product->update($data);

        // Определяем тип продукта
        $productType = $data['product_type'] ?? ($product->pot ? 'pot' : ($product->bench ? 'bench' : null));

        if (!$productType) {
            abort(404, 'Тип продукта не определен');
        }

        // Обновляем специфичные данные в зависимости от типа
        switch ($productType) {
            case 'pot':
                $pot = $product->pot;
                if ($pot) {
                    $pot->update($data);
                }

                $routes = [
                    'Square' => route('admin_square_pots'),
                    'Round' => route('admin_round_pots'),
                    'Rectangular' => route('admin_rectangular_pots'),
                ];
                break;

            case 'bench':
                $bench = $product->bench;
                if ($bench) {
                    $bench->update($data);
                }

                $routes = [
                    'Verona' => route('admin_benches_verona'),
                    'Stones' => route('admin_benches_stones'),
                    'lines' => route('admin_benches_solo'),
                    'Solo' => route('admin_benches_lines'),
                    'Street_furniture' => route('admin_benches_street_furniture'),
                ];
                break;

            default:
                abort(404, 'Неизвестный тип продукта');
        }

        // Обрабатываем новые изображения
        if ($request->hasFile('image')) {
            $images = $request->file('image');
            $imageData = $request->input('image_data', []);

            // Если это одно изображение (скамейка), преобразуем в массив
            if (!is_array($images)) {
                $images = [$images];
                $imageData = [$imageData];
            }

            foreach ($images as $index => $file) {
                $imageDataForFile = $imageData[$index] ?? [];

                $this->imageService->save(
                    file: $file,
                    model: $product,
                    data: $imageDataForFile
                );
            }
        }

        $collection = $data['collection'];
        return redirect($routes[$collection]);
    }

    public function delete()
    {

    }
}
