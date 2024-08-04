<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Models\BenchImage;
use App\Models\BenchProduct;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class BenchImageController extends Controller
{

    public function bench_image_update(BenchImage $benchImage, BenchProduct $benchProduct, ImageRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $name= save_image($file, BenchImage::query());
                $path = Storage::putFileAs('public/images', $file, $name); // Даем путь к этому файлу
                $data['image'] = $path;
                BenchImage::create($data);

                ImageManager::gd()->read($file)->scaleDown(480,  400)->save(storage_path('app/public/images/'.$name));
            }
        }

        $benchImage->fill($data)->save();

        return redirect(route('benchProducts.edit', ['benchProduct' => $benchProduct]));
    }

    public function bench_image_destroy(BenchImage $benchImage, BenchProduct $benchProduct)
    {
        Storage::delete($benchImage->image);

        $benchImage->delete();

        return redirect(route('benchProducts.edit', ['benchProduct' => $benchProduct]));
    }
}
