<?php

namespace App\Http\Controllers;

use App\Http\Requests\GalleryRequest;
use App\Http\Requests\ImageRequest;
use App\Models\Gallery;
use App\Models\GalleryImage;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GalleryRequest $galleryRequest)
    {
        $data = $galleryRequest->all();

        if ($galleryRequest->hasFile('image')) {
            foreach ($galleryRequest->file('image') as $file) {
                $gallery = Gallery::create($data);
                $data['gallery_image_id'] = $gallery->id;
//                dd($file);
                $name = save_image($file, GalleryImage::query());
//                dd($name);
//                $path = Storage::putFileAs('images', $file, $name); // Даем путь к этому файлу
                $path = Storage::putFileAs('public/images', $file, $name); // Даем путь к этому файлу
//                dd($path);
                $data['image'] = $path;
                GalleryImage::create($data);

                ImageManager::gd()->read($file)->scaleDown(100,  100)->save(storage_path('app/public/images/'.save_image($file, GalleryImage::query())));
            }
        }

        return redirect(route('admin_gallery'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ImageRequest $request, Gallery $gallery)
    {
        $data = $request->all();
        $images = $gallery->gallery_images()->where('gallery_image_id', $gallery->attributesToArray()['id'])->get();
        foreach ($images as $image) {
            $image->fill($data)->save();
        }

        return redirect(route('admin_gallery'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        $images = $gallery->gallery_images()->where('gallery_image_id', $gallery->attributesToArray()['id'])->get();
//        dd($images);
        foreach ($images as $image) {
            Storage::delete($image->image);
        }
        $gallery->delete();

        return redirect(route('admin_gallery'));
    }
}
