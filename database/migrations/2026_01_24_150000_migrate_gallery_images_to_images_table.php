<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Gallery;
use App\Models\Image;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Переносим данные из gallery_images в images
        $galleryImages = DB::table('gallery_images')->get();

        foreach ($galleryImages as $galleryImage) {
            // Проверяем, существует ли галерея
            $gallery = DB::table('galleries')->find($galleryImage->gallery_image_id);
            
            if ($gallery) {
                // Нормализуем путь к изображению (если он не содержит 'public/', добавляем)
                $imagePath = $galleryImage->image;
                if ($imagePath && !str_starts_with($imagePath, 'public/')) {
                    // Если путь начинается с 'images/', добавляем 'public/'
                    if (str_starts_with($imagePath, 'images/')) {
                        $imagePath = 'public/' . $imagePath;
                    } elseif (!str_starts_with($imagePath, 'public/')) {
                        // Если путь относительный, предполагаем что это 'public/images/...'
                        $imagePath = 'public/images/' . basename($imagePath);
                    }
                }
                
                // Проверяем, не существует ли уже такое изображение
                $existingImage = DB::table('images')
                    ->where('imageable_id', $gallery->id)
                    ->where('imageable_type', Gallery::class)
                    ->where('image', $imagePath)
                    ->first();

                if (!$existingImage) {
                    // Переносим изображение в таблицу images
                    DB::table('images')->insert([
                        'imageable_id' => $gallery->id,
                        'imageable_type' => Gallery::class,
                        'image' => $imagePath,
                        'description_image' => $galleryImage->description_image,
                        'created_at' => $galleryImage->created_at ?? now(),
                        'updated_at' => $galleryImage->updated_at ?? now(),
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Удаляем изображения галерей из таблицы images
        DB::table('images')
            ->where('imageable_type', Gallery::class)
            ->delete();
    }
};
