<?php

namespace App\Services;

use App\Helpers\GenerateUniqueNameHelper;
use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;

class ImageService
{
    public function save($file, Model $model)
    {
//        $name= save_image($file, Image::query());
//        $path = Storage::putFileAs('public/images', $file, $name); // Даем путь к этому файлу
//        $data['image'] = $path;
//        $product->images()->create($data);
//
//        ImageManager::gd()->read($file)->scaleDown(480,  400)->save(storage_path('app/public/images/'.$name));
//
//
//
//        $extension = $file->getClientOriginalExtension();
//        $name = hash('md5', $file->getClientOriginalName()) . '.webp';
//
//        // Конвертация в WebP
//        try {
//            ImageManager::gd()
//                ->read($file)
//                ->toWebp(100)
//                ->save(storage_path('app/public/images/' . $name));
//
//            $data['image'] = 'storage/images/' . $name;
//        } catch (\Exception $e) {
//            // Если WebP не поддерживается, сохраняем оригинал
//            $name = hash('md5', $file->getClientOriginalName()) . '.' . $extension;
//            Storage::putFileAs('public/images', $file, $name);
//            $data['image'] = 'storage/images/' . $name;
//        }

        DB::transaction(function () use ($file, $model) {

            $disk = Storage::disk(config('filesystems.default'));

            $interventionManager = new ImageManager(new Driver());

            $name = str_replace($file->getClientOriginalExtension(), '', str_replace(' ', '_', $file->getClientOriginalName()));

            $originalName = (new GenerateUniqueNameHelper)->generateUniqueName(originalName: $name.'webp', disk: $disk, folder: 'images');

            $item = $interventionManager->read($file->getPathname());

            $converted_image = $item->toWebp(100);

            $path = 'images/'.$originalName;

            $disk->put($path, $converted_image);

            $model->images()->create(
                [
                    'image' =>   $path,
                ]
            );
        });
    }
}
