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
    public function save(array $images, Model $model, array $imageData = []): void
    {
        DB::transaction(function () use ($images, $model, $imageData) {
            if (!is_array($images)) {
                $images = [$images];
                $imageData = [$imageData];
            }

            foreach ($images as $index => $file) {
                $imageDataForFile = $imageData[$index] ?? [];

                $disk = Storage::disk('public');
                $interventionManager = ImageManager::gd();

                $name = str_replace(' ', '_', pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));

                $originalName = (new GenerateUniqueNameHelper)->generateUniqueName(
                    originalName: $name . '.webp',
                    disk: $disk,
                    folder: 'images'
                );

                $item = $interventionManager->read($file->getPathname());

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
                    'description_image' => $imageDataForFile['description_image'] ?? null,
                    'color' => $imageDataForFile['color'] ?? null,
                    'texture' => $imageDataForFile['texture'] ?? null,
                ]);
            }
        });
    }

    public function update(Image $image,$data): bool
    {
        return $image->update($data);
    }

    public function delete(Image $image): bool
    {
        if ($image->image) {
            $path = str_replace('public/', '', $image->image);
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        return $image->delete();
    }
}
