<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Переносит изображения блога из поля blogs.main_image в таблицу images
     * (полиморфная связь с Blog).
     */
    public function up(): void
    {
        $blogs = DB::table('blogs')
            ->whereNotNull('main_image')
            ->where('main_image', '!=', '')
            ->get();

        $now = now();

        foreach ($blogs as $blog) {
            // Не создаём дубликат, если для этого блога уже есть запись в images с main_image = true
            $exists = DB::table('images')
                ->where('imageable_type', 'App\Models\Blog')
                ->where('imageable_id', $blog->id)
                ->where('main_image', true)
                ->exists();

            if ($exists) {
                continue;
            }

            DB::table('images')->insert([
                'imageable_id' => $blog->id,
                'imageable_type' => 'App\Models\Blog',
                'image' => $blog->main_image,
                'description_image' => null,
                'color' => null,
                'texture' => null,
                'main_image' => true,
                'menu_image' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    /**
     * Удаляет записи в images, созданные этой миграцией (только для Blog с main_image = true).
     * Поле blogs.main_image не трогаем — там остаются старые пути.
     */
    public function down(): void
    {
        DB::table('images')
            ->where('imageable_type', 'App\Models\Blog')
            ->where('main_image', true)
            ->delete();
    }
};
