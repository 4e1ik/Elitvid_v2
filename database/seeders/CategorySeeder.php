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
            'benches',
            'lines_benches',
            'solo_benches',
            'stones_benches',
            'street_furniture_benches',
            'verona_benches',
            'pots',
            'rectangular_pots',
            'round_pots',
            'square_pots',
            'bollards_and_fencing',
            'decorations',
            'directions',
            'facade_stucco_molding_and_panels',
            'parklets_and_canopies',
            'pillars_and_covers',
            'rotundas_and_colonnades',
            'blog',
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

        // Вставляем данные в таблицу categories
        DB::table('categories')->insert($categories);
    }
}
