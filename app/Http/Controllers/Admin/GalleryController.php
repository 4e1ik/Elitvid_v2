<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GalleryRequest;
use App\Http\Requests\ImageRequest;
use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = Gallery::all();
        return view('admin.gallery.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

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
                $name = save_image($file, GalleryImage::query());
                $path = Storage::putFileAs('public/images', $file, $name); // Даем путь к этому файлу
                $data['image'] = $path;
                GalleryImage::create($data);

                ImageManager::gd()->read($file)->scaleDown(1180,  592)->save(storage_path('app/public/images/'.$name));
            }
        }

        $collection = $data['type'];

        $potsRoutes = [
            'pots' => route('admin_pots_images'),
            'benches' => route('admin_benches_images'),
            'main_page' => route('admin_main_page_images'),
            'decorative_elements' => route('admin_decorative_elements_images'),
            'bollards' => route('admin_bollards_images'),
            'parklets_and_naves' => route('admin_parklets_and_naves_images'),
            'columns_and_panels' => route('admin_columns_and_panels_images'),
            'facade_walls' => route('admin_facade_walls_images'),
            'rotundas' => route('admin_rotundas_images'),
            'maf' => route('admin_maf_images'),
            'concrete_products' => route('admin_concrete_products_images'),
        ];

        return redirect($potsRoutes[$collection]);
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

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        $images = $gallery->gallery_images()->where('gallery_image_id', $gallery->attributesToArray()['id'])->get();
        foreach ($images as $image) {
            Storage::delete($image->image);
        }
        $gallery->delete();

        return back();
    }
}
