<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\MetaTag;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\PageContent;

class PageContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Маппинг страниц на типы галерей
        $pageToGalleryType = [
            'main' => 'main_page',
            'pots' => 'pots',
            'benches' => 'benches',
            'decorations' => 'decorative_elements',
            'bollards_and_fencing' => 'bollards',
        ];

        // Получаем все страницы из PageNamesHelper
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

        foreach ($pages as $page) {
            // Получаем мета-теги
            $metaTag = MetaTag::where('page', $page)->first();
            
            // Получаем категорию
            $category = Category::where('page', $page)->first();

            // Создаем или обновляем запись в page_contents
            $pageContent = PageContent::updateOrCreate(
                ['page' => $page],
                [
                    'meta_title' => $metaTag->title ?? null,
                    'meta_description' => $metaTag->description ?? null,
                    'category_description' => $category->description ?? null,
                ]
            );

            // Связываем галерею через полиморфную связь, если она существует
            $galleryType = $pageToGalleryType[$page] ?? null;
            if ($galleryType) {
                // Ищем галерею по типу, которая еще не связана с PageContent
                $gallery = Gallery::where('type', $galleryType)
                    ->whereNull('galleriable_id')
                    ->first();
                
                // Если нашли галерею, связываем её с PageContent через полиморфную связь
                if ($gallery && !$pageContent->gallery) {
                    $gallery->update([
                        'galleriable_id' => $pageContent->id,
                        'galleriable_type' => PageContent::class,
                    ]);
                }
            }
        }

        $this->command->info('Миграция данных в page_contents завершена!');
    }
}
