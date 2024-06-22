<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Models\Gallery;
use App\Models\Image;
use App\Models\Post;
use App\Models\Product;
use App\Models\Texture;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function store(ImageRequest $request)
    {
        $data = $request->all();

//        save_image($request);

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $name = $file->getClientOriginalName();
                $path = Storage::putFileAs('images', $file, save_image($file)); // Даем путь к этому файлу
                $data['image'] = $path;
                Image::create($data);
            }
        }

        return redirect(route('admin_gallery'));
    }

    public function update(Image $image, Product $product, ImageRequest $request)
    {
        $data = $request->all();

        $image->fill($data)->save();

        return redirect(route('products.edit', ['product' => $product]));
    }

    public function destroy(Image $image, Product $product) {

        Storage::delete($image->image);

        $image->delete();

        return redirect(route('products.edit', ['product' => $product]));
    }

    public function gallery_image_destroy(Image $image, Gallery $gallery)
    {
        Storage::delete($image->image);

        $image->delete();

        if (!$image->query()->where('gallery_id', $gallery->id)->exists()){
            $gallery->delete();
        }

        return redirect(route('admin_gallery'));
    }

    public function gallery_image_update(ImageRequest $request, Image $image)
    {
        $data = $request->all();

        $image->fill($data)->save();

        if(!$image['texture_id'] == null){
            return redirect(route('admin_textures'));
        }

        return redirect(route('admin_gallery'));
    }

    public function texture_image_destroy(Image $image, Texture $texture)
    {
        Storage::delete($image->image);

        $image->delete();

        return redirect(route('textures.edit', ['texture' => $texture]));
    }

    public function texture_image_update(Image $image, Texture $texture, Request $request)
    {
        $data = $request->all();

        $image->fill($data)->save();

        return redirect(route('textures.edit', ['texture' => $texture]));
    }
}
