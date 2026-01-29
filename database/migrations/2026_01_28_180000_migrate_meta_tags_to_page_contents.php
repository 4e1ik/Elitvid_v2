<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Переносит данные из таблицы meta_tags в page_contents.
     * Перезаписывает существующие значения meta_title и meta_description.
     */
    public function up(): void
    {
        // Убеждаемся, что поля meta_title и meta_description существуют в page_contents
        if (!Schema::hasColumn('page_contents', 'meta_title')) {
            Schema::table('page_contents', function (Blueprint $table) {
                $table->string('meta_title', 255)->nullable()->after('page');
            });
        }

        if (!Schema::hasColumn('page_contents', 'meta_description')) {
            Schema::table('page_contents', function (Blueprint $table) {
                $table->text('meta_description')->nullable()->after('meta_title');
            });
        }

        // Получаем все записи из meta_tags
        $metaTags = DB::table('meta_tags')->get();

        foreach ($metaTags as $metaTag) {
            // Ищем соответствующую запись в page_contents по полю page
            $pageContent = DB::table('page_contents')
                ->where('page', $metaTag->page)
                ->first();

            if ($pageContent) {
                // Если запись существует - обновляем meta_title и meta_description
                DB::table('page_contents')
                    ->where('id', $pageContent->id)
                    ->update([
                        'meta_title' => $metaTag->title,
                        'meta_description' => $metaTag->description,
                        'updated_at' => now(),
                    ]);
            } else {
                // Если записи нет - создаём новую
                DB::table('page_contents')->insert([
                    'page' => $metaTag->page,
                    'meta_title' => $metaTag->title,
                    'meta_description' => $metaTag->description,
                    'category_description' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     * 
     * Откат миграции не выполняется, так как данные в meta_tags остаются нетронутыми.
     */
    public function down(): void
    {
        // Данные в meta_tags не удаляются, поэтому откат не требуется
        // Если нужно откатить изменения в page_contents, можно очистить meta_title и meta_description
        // DB::table('page_contents')->update([
        //     'meta_title' => null,
        //     'meta_description' => null,
        // ]);
    }
};
