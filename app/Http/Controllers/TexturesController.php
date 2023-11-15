<?php

namespace App\Http\Controllers;

use App\Http\Requests\TextureRequest;
use App\Models\Image;
use App\Models\Product;
use App\Models\r;
use App\Models\Texture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TexturesController extends Controller
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
    public function store(TextureRequest $textureRequest)
    {
        $data = $textureRequest->all();

        $texture = Texture::create($data);

        $data['texture_id'] = $texture->id;

        if ($textureRequest->hasFile('image')) {
            foreach ($textureRequest->file('image') as $file) {
                $path = Storage::putFileAs('images', $file, save_image($file)); // Даем путь к этому файлу
                $data['image'] = $path;
                Image::create($data);
            }
        }

        return redirect(route('admin_textures'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Texture $texture)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Texture $texture)
    {
        $image = Image::where('texture_id', $texture->id)->first();

        return view('includes.elitvid.admin.update_texture', compact( 'texture', 'image'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TextureRequest $textureRequest, Texture $texture)
    {
        $data = $textureRequest->all();

        $texture->fill($data)->save();

        $data['texture_id'] = $texture->id;

//        save_image($textureRequest);

        if ($textureRequest->hasFile('image')) {
            foreach ($textureRequest->file('image') as $file) {
                $name = $file->getClientOriginalName();
                $path = Storage::putFileAs('images', $file, save_image($file)); // Даем путь к этому файлу
                $data['image'] = $path;
                Image::create($data);
            }
        }

        return redirect(route('admin_textures'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Texture $texture)
    {
        $images = $texture->images()->where('texture_id', $texture->id)->get();
        foreach ($images as $image) {
            Storage::delete($image->image);
        }

        $texture->delete();

        return redirect(route('admin_textures'));
    }
}
