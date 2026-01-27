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
        // Редиректим на страницу контента, так как все галереи теперь управляются там
        return redirect()->route('admin_page_contents.index');
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
            // Находим или создаем одну галерею для этого типа
            $gallery = Gallery::firstOrCreate(
                ['type' => $data['type']],
                [
                    'type' => $data['type'],
                    'active' => $data['active'] ?? true,
                ]
            );

            foreach ($galleryRequest->file('image') as $file) {
                $data['gallery_image_id'] = $gallery->id;
                $name = save_image($file, GalleryImage::query());
                $path = Storage::putFileAs('public/images', $file, $name); // Даем путь к этому файлу
                $data['image'] = $path;
                GalleryImage::create($data);

                ImageManager::gd()->read($file)->scaleDown(1180,  592)->save(storage_path('app/public/images/'.$name));
            }
        }

        $collection = $data['type'];

        // Маппинг типов галерей на страницы контента
        $typeToPageMap = [
            'pots' => 'pots',
            'benches' => 'benches',
            'main_page' => 'main',
            'decorative_elements' => 'decorations',
            'bollards' => 'bollards_and_fencing',
        ];

        $page = $typeToPageMap[$collection] ?? null;

        if ($page) {
            return redirect()->route('admin_page_contents.edit', $page)
                ->with('success', 'Изображения успешно добавлены в галерею');
        }

        return back()->with('success', 'Изображения успешно добавлены в галерею');
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
