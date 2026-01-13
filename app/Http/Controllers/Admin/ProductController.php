<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateProductRequest;
use App\Models\PotImage;
use App\Models\PotProduct;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class ProductController
{
    public function store(CreateProductRequest $request)
    {
        $data = $request->all();
        dd($data);

        $data['size'] = [];
        $data['weight'] = [];
        $data['price'] = [];
        for ($i = 1;  $i<=5; $i++){
            $data['size'][$i] = $data['size'.$i];
            $data['weight'][$i] = $data['weight'.$i];
            $data['price'][$i] = $data['price'.$i];
        }
        $data['size'] = implode('|', $data['size']);
        $data['weight'] = implode('|', $data['weight']);
        $data['price'] = implode('|', $data['price']);

        $potProduct = PotProduct::create($data);

        $data['pot_product_id'] = $potProduct->id;

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $name= save_image($file, PotImage::query());
                $path = Storage::putFileAs('public/images', $file, $name); // Даем путь к этому файлу
                $data['image'] = $path;
                PotImage::create($data);

                ImageManager::gd()->read($file)->scaleDown(480,  400)->save(storage_path('app/public/images/'.$name));

            }
        }

        $collection = $data['collection'];

        $potsRoutes = [
            'Square' => route('admin_square_pots'),
            'Round' => route('admin_round_pots'),
            'Rectangular' => route('admin_rectangular_pots'),
        ];

        return redirect($potsRoutes[$collection]);
    }
}
