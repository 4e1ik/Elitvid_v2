<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            'main',
            'directions',
            'decorations',
            'blog',
            'benches',
            'pots',
            'bollards_and_fencing',
            'verona_benches',
            'street_furniture_benches',
            'solo_benches',
            'lines_benches',
            'stones_benches',
            'rectangular_pots',
            'square_pots',
            'round_pots',
        ];

        // Создаем массив данных для вставки
        $categories = array_map(function ($page) {
            return [
                'description' => ' ', // Пустое описание
                'page' => $page,      // Уникальное значение из массива
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $pages);

        // Используем updateOrInsert чтобы не создавать дубликаты
        foreach ($categories as $category) {
            DB::table('categories')->updateOrInsert(
                ['page' => $category['page']],
                $category
            );
        }
    }
}
