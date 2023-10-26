<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Models\Image;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function store(ImageRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $name = $file->getClientOriginalName();
                $path = Storage::putFileAs('images', $file, $name); // Даем путь к этому файлу
                $data['image'] = $path;
                Image::create($data);
            }
        }

        return redirect(route('admin_gallery'));
    }

    public function update(string $id, Post $post, ImageRequest $request)
    {
//        dd($post);
        $data = $request->all();

        //dd($data);

        $image = Image::where('id', $id)->get();

        //dd($image);

        foreach ($image as $item) {

            $item->fill($data)->save();

            //dd($item);
        }

        return redirect(route('posts.show', compact('post')));
    }

    public function destroy(string $id, Post $post) {

        Image::where('id', $id)->delete();

        return redirect(route('posts.show', compact('post')));
    }

    public function gallery_image_destroy(string $id)
    {
        Image::where('id', $id)->delete();

        return redirect(route('admin_gallery'));
    }

    public function gallery_image_update(ImageRequest $request, Image $image)
    {

        $data = $request->all();

        $image->fill($data)->save();

        return redirect(route('admin_gallery'));
    }
}
