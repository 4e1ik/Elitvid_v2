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
        // Получаем все уникальные типы галерей
        $galleryTypes = DB::table('galleries')
            ->whereNotNull('type')
            ->distinct()
            ->pluck('type');

        foreach ($galleryTypes as $type) {
            // Находим все галереи этого типа
            $galleries = DB::table('galleries')
                ->where('type', $type)
                ->orderBy('id')
                ->get();

            if ($galleries->count() <= 1) {
                continue; // Если галерея одна, пропускаем
            }

            // Берем первую галерею как основную
            $mainGallery = $galleries->first();
            $otherGalleries = $galleries->skip(1);

            // Переносим все изображения из других галерей в основную
            foreach ($otherGalleries as $gallery) {
                // Переносим изображения из таблицы images
                DB::table('images')
                    ->where('imageable_id', $gallery->id)
                    ->where('imageable_type', Gallery::class)
                    ->update([
                        'imageable_id' => $mainGallery->id,
                    ]);

                // Переносим изображения из старой таблицы gallery_images
                DB::table('gallery_images')
                    ->where('gallery_image_id', $gallery->id)
                    ->update([
                        'gallery_image_id' => $mainGallery->id,
                    ]);

                // Если галерея связана с PageContent, переносим связь
                if ($gallery->galleriable_id && $gallery->galleriable_type) {
                    // Проверяем, не связана ли уже основная галерея
                    $mainGalleryHasRelation = DB::table('galleries')
                        ->where('id', $mainGallery->id)
                        ->whereNotNull('galleriable_id')
                        ->exists();

                    if (!$mainGalleryHasRelation) {
                        // Переносим полиморфную связь на основную галерею
                        DB::table('galleries')
                            ->where('id', $mainGallery->id)
                            ->update([
                                'galleriable_id' => $gallery->galleriable_id,
                                'galleriable_type' => $gallery->galleriable_type,
                            ]);
                    }
                }

                // Удаляем дублирующуюся галерею
                DB::table('galleries')->where('id', $gallery->id)->delete();
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Откат миграции сложен, так как мы объединили данные
        // Оставляем пустым или создаем логику разделения при необходимости
    }
};
