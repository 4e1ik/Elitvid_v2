<?php

namespace App\Services;

use App\Helpers\GenerateUniqueNameHelper;
use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class ImageService
{
    public function save($file, Model $model, array $data)
    {
        DB::transaction(function () use ($file, $model, $data) {

            $disk = Storage::disk('public');

            $interventionManager = ImageManager::gd();

            $name = str_replace(' ', '_', pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));

            $originalName = (new GenerateUniqueNameHelper)->generateUniqueName(originalName: $name . '.webp', disk: $disk, folder: 'images');

            $item = $interventionManager->read($file->getPathname());

            // Ресайз изображения
            $item = $item->scaleDown(480, 400);

            // Конвертация в WebP
            try {
                $converted_image = $item->toWebp(100);
            } catch (\Exception $e) {
                $extension = $file->getClientOriginalExtension();
                $originalName = (new GenerateUniqueNameHelper)->generateUniqueName(
                    originalName: $name . '.' . $extension,
                    disk: $disk,
                    folder: 'images'
                );
                $converted_image = $item->encode();
            }

            $path = 'images/' . $originalName;

            $disk->put($path, $converted_image);

            $storagePath = 'public/' . $path;

            $model->images()->create([
                'image' => $storagePath,
                'description_image' => $data['description_image'] ?? null,
                'color' => $data['color'] ?? null,
                'texture' => $data['texture'] ?? null,
            ]);
        });
    }
}
