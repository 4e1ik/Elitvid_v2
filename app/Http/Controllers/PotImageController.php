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
    public function pot_image_store(ImageRequest $request)
    {
//        $data = $request->all();
//
////        save_image($request);
//
//        if ($request->hasFile('image')) {
//            foreach ($request->file('image') as $file) {
//                $path = Storage::putFileAs('images', $file, save_image($file)); // Даем путь к этому файлу
//                $data['image'] = $path;
//                PotImage::create($data);
//
//                ImageManager::gd()->read($file)->scaleDown(360,  275)->save(storage_path('app/public/images/'.'test'.save_image($file)));
//            }
//        }
//
//        return redirect(route('admin_pots'));
    }

    public function pot_image_update(PotImage $potImage, PotProduct $potProduct, ImageRequest $request)
    {
        $data = $request->all();

//        $data['image'] = $potImage->image;

//        dd($data);

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $path = Storage::putFileAs('images', $file, save_image($file, PotImage::query())); // Даем путь к этому файлу
                $data['image'] = $path;
                PotImage::create($data);

                ImageManager::gd()->read($file)->scaleDown(360,  290)->save(storage_path('app/images/'.save_image($file, PotImage::query())));
            }
        }

//        $tmp_img_path = explode('/', $data['image']);
//        $tmp_name_image_with_extension = end($tmp_img_path);
//        $tmp_name_image_arr = explode('.', $tmp_name_image_with_extension);
//        $tmp_name_image = array_shift($tmp_name_image_arr);
//        $new_name_image = $tmp_name_image.'_'.$data['texture'].'_'.$data['color'].'.'.end($tmp_name_image_arr);
//
//        $data['image'] = $new_name_image;

//        dd($data);


        $potImage->fill($data)->save();

        return redirect(route('potProducts.edit', ['potProduct' => $potProduct]));
    }

//    public function getProductImage(\Illuminate\Http\Request $request)
//    {
//        $texture = $request->input('texture');
//        $color = $request->input('color');
//
//        // Получение ссылки на изображение товара с определенными значениями текстуры и цвета из базы данных
//        $product = PotImage::qouery()->where('texture', $texture)
//            ->where('color', $color)
//            ->first();
//
//        if ($product) {
//            return response()->json([
//                'image_url' => asset($product->image)
//            ]);
//        } else {
//            return response()->json([
//                'error' => 'Product not found'
//            ], 404);
//        }
//    }

    public function pot_image_destroy(PotImage $potImage, PotProduct $potProduct)
    {
        Storage::delete($potImage->image);

        $potImage->delete();

        return redirect(route('potProducts.edit', ['potProduct' => $potProduct]));
    }
}
