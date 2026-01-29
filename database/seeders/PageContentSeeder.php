<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
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

        // Получаем все страницы из конфига pages.php
        $pages = array_keys(config('pages', []));

        foreach ($pages as $page) {
            // Получаем мета-теги из старой таблицы (если миграция еще не выполнена)
            // Пробуем оба варианта названия таблицы для обратной совместимости
            $metaTag = null;
            if (Schema::hasTable('meta_tags')) {
                $metaTag = DB::table('meta_tags')->where('page', $page)->first();
            } elseif (Schema::hasTable('metatags')) {
                $metaTag = DB::table('metatags')->where('page', $page)->first();
            }
            
            // Получаем категорию из старой таблицы (если миграция еще не выполнена)
            $category = null;
            if (Schema::hasTable('categories')) {
                $category = DB::table('categories')->where('page', $page)->first();
            }

            // Создаем или обновляем запись в page_contents
            // Если запись уже существует (создана миграциями), обновляем только пустые поля
            $pageContent = PageContent::firstOrNew(['page' => $page]);
            
            // Обновляем только если поля пустые (чтобы не перезаписать данные из миграций)
            if (empty($pageContent->meta_title) && $metaTag) {
                $pageContent->meta_title = $metaTag->title;
            }
            if (empty($pageContent->meta_description) && $metaTag) {
                $pageContent->meta_description = $metaTag->description;
            }
            if (empty($pageContent->category_description) && $category) {
                $pageContent->category_description = $category->description;
            }
            
            $pageContent->save();

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
