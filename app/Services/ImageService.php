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
    /**
     * Читает изображение, при необходимости используя Imagick (для HEIC и др., когда GD не поддерживает).
     */
    private function readImage(string $pathname): \Intervention\Image\Interfaces\ImageInterface
    {
        try {
            return ImageManager::gd()->read($pathname);
        } catch (\Throwable $e) {
            if (extension_loaded('imagick')) {
                try {
                    return ImageManager::imagick()->read($pathname);
                } catch (\Throwable) {
                    // fallthrough to rethrow original
                }
            }
            throw $e;
        }
    }

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
                $pathname = $file->getPathname();

                $name = str_replace(' ', '_', pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));

                try {
                    // Пытаемся прочитать и перекодировать через Intervention (WebP)
                    $originalName = (new GenerateUniqueNameHelper)->generateUniqueName(
                        originalName: $name . '.webp',
                        disk: $disk,
                        folder: 'images'
                    );

                    $item = $this->readImage($pathname);

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
                } catch (\Throwable $e) {
                    // Fallback: если ни GD, ни Imagick не смогли прочитать (например, HEIC без поддержки) —
                    // просто сохраняем оригинальный файл как есть.
                    $extension = $file->getClientOriginalExtension() ?: 'bin';
                    $originalName = (new GenerateUniqueNameHelper)->generateUniqueName(
                        originalName: $name . '.' . $extension,
                        disk: $disk,
                        folder: 'images'
                    );

                    $path = 'images/' . $originalName;
                    // putFileAs сам прочитает содержимое UploadedFile
                    $disk->putFileAs('images', $file, $originalName);
                }

                $storagePath = 'public/' . $path;

                $model->images()->create([
                    'image' => $storagePath,
                    'description_image' => $imageDataForFile['description_image'] ?? null,
                    'color' => $imageDataForFile['color'] ?? null,
                    'texture' => $imageDataForFile['texture'] ?? null,
                    'main_image' => $imageDataForFile['main_image'] ?? false,
                    'menu_image' => $imageDataForFile['menu_image'] ?? false,
                ]);
            }
        });
    }

    public function update(Image $image, $data): bool
    {
        return DB::transaction(function () use ($image,$data) {
            return $image->update($data);
        });

    }

    public function delete(Image $image): bool
    {
        return DB::transaction(function () use ($image) {
            if ($image->image) {
                $path = str_replace('public/', '', $image->image);
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }

            return $image->delete();
        });
    }
}
