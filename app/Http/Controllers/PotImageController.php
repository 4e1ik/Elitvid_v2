<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Models\PotImage;
use App\Models\PotProduct;
use http\Client\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class PotImageController extends Controller
{

    public function pot_image_update(PotImage $potImage, PotProduct $potProduct, ImageRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $name = save_image($file, PotImage::query());
                $path = Storage::putFileAs('images', $file, $name); // Даем путь к этому файлу
                $data['image'] = $path;
                PotImage::create($data);

                ImageManager::gd()->read($file)->scaleDown(360,  290)->save(storage_path('app/public/images/'.$name));
            }
        }

        $potImage->fill($data)->save();

        return redirect(route('potProducts.edit', ['potProduct' => $potProduct]));
    }

    public function pot_image_destroy(PotImage $potImage, PotProduct $potProduct)
    {
        Storage::delete($potImage->image);

        $potImage->delete();

        return redirect(route('potProducts.edit', ['potProduct' => $potProduct]));
    }
}
