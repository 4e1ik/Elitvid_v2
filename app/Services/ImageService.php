<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class ImageService
{
    public function save($file, Model $product)
    {
        $name= save_image($file, Image::query());
        $path = Storage::putFileAs('public/images', $file, $name); // Даем путь к этому файлу
        $data['image'] = $path;
        $product->images()->create($data);

        ImageManager::gd()->read($file)->scaleDown(480,  400)->save(storage_path('app/public/images/'.$name));



        $extension = $file->getClientOriginalExtension();
        $name = hash('md5', $file->getClientOriginalName()) . '.webp';

        // Конвертация в WebP
        try {
            ImageManager::gd()
                ->read($file)
                ->toWebp(100)
                ->save(storage_path('app/public/images/' . $name));

            $data['image'] = 'storage/images/' . $name;
        } catch (\Exception $e) {
            // Если WebP не поддерживается, сохраняем оригинал
            $name = hash('md5', $file->getClientOriginalName()) . '.' . $extension;
            Storage::putFileAs('public/images', $file, $name);
            $data['image'] = 'storage/images/' . $name;
        }
    }
}
