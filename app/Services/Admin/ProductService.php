<?php

namespace App\Services\Admin;

use App\Helpers\SlugGenerateHelper;
use App\Models\Bench;
use App\Models\Pot;
use App\Models\Product;
use App\Services\ImageService;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function __construct(
        public ImageService $imageService,
        public SlugGenerateHelper $slugGenerateHelper,
    ) {}

    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {
            if (empty($data['slug']) && !empty($data['name'])) {
                $data['slug'] = $this->slugGenerateHelper->slug($data['name']);
            }

            $product = Product::create($data);

            $data['product_id'] = $product->id;

            switch ($data['product_type']) {
                case 'bench':
                    Bench::create($data);
                    break;

                case 'pot':
                    Pot::create($data);
                    break;
            }

            if (!empty($data['image'])) {
                $this->imageService->save(
                    images: $data['image'],
                    model: $product,
                    imageData: $data['image_data'] ?? []
                );
            }

            return $product;
        });
    }

    public function update(array $data, Product $product)
    {
        return DB::transaction(function () use ($data, $product) {
            if (empty($data['slug']) && !empty($data['name'])) {
                $data['slug'] = $this->slugGenerateHelper->slug($data['name']);
            }

            $product->update($data);

            $productType = $data['product_type'] ?? $product->product_type ?? ($product->pot ? 'pot' : ($product->bench ? 'bench' : null));

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

                    break;

                case 'bench':
                    $bench = $product->bench;
                    if ($bench) {
                        $bench->update($data);
                    }

                    break;

                default:
                    abort(404, 'Неизвестный тип продукта');
            }

            // Обрабатываем новые изображения
            if (!empty($data['image'])) {
                $this->imageService->save(
                    images: $data['image'],
                    model: $product,
                    imageData: $data['image_data'] ?? []
                );
            }

            return $product;
        });
    }

    public function destroy(Product $product):bool
    {
        return DB::transaction(function () use ($product) {
            foreach ($product->images as $image) {
                $this->imageService->delete($image);
            }

            return $product->delete();
        });
    }
}
