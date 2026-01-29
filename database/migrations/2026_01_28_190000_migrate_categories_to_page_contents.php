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
     * Переносит данные из таблицы categories в page_contents.
     * Обновляет существующие значения category_description.
     */
    public function up(): void
    {
        // Убеждаемся, что поле category_description существует в page_contents
        if (!Schema::hasColumn('page_contents', 'category_description')) {
            Schema::table('page_contents', function (Blueprint $table) {
                $table->longText('category_description')->nullable()->after('meta_description');
            });
        }

        // Проверяем существование таблицы categories
        if (!Schema::hasTable('categories')) {
            // Таблица categories не существует, пропускаем миграцию данных
            return;
        }

        // Получаем все записи из categories
        $categories = DB::table('categories')->get();

        foreach ($categories as $category) {
            // Ищем соответствующую запись в page_contents по полю page
            $pageContent = DB::table('page_contents')
                ->where('page', $category->page)
                ->first();

            if ($pageContent) {
                // Если запись существует - обновляем category_description
                // Обновляем только если category_description пустое, чтобы не перезаписать существующие данные
                if (empty($pageContent->category_description)) {
                    DB::table('page_contents')
                        ->where('id', $pageContent->id)
                        ->update([
                            'category_description' => $category->description,
                            'updated_at' => now(),
                        ]);
                }
            } else {
                // Если записи нет - создаём новую
                DB::table('page_contents')->insert([
                    'page' => $category->page,
                    'meta_title' => null,
                    'meta_description' => null,
                    'category_description' => $category->description,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     * 
     * Откат миграции не выполняется, так как данные в categories остаются нетронутыми.
     */
    public function down(): void
    {
        // Данные в categories не удаляются, поэтому откат не требуется
        // Если нужно откатить изменения в page_contents, можно очистить category_description
        // DB::table('page_contents')->update([
        //     'category_description' => null,
        // ]);
    }
};
