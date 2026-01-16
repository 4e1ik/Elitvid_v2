<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();
        
        // Удаляем старые поля и добавляем новые в одной транзакции
        Schema::table('static_pages', function (Blueprint $table) {
            // Удаляем старые поля
            if (Schema::hasColumn('static_pages', 'page')) {
                $table->dropColumn('page');
            }
            if (Schema::hasColumn('static_pages', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('static_pages', 'main_image')) {
                $table->dropColumn('main_image');
            }
            if (Schema::hasColumn('static_pages', 'alt_image')) {
                $table->dropColumn('alt_image');
            }
            
            // Добавляем новые поля
            if (!Schema::hasColumn('static_pages', 'title')) {
                $table->string('title', 500)->nullable()->after('id')->comment('H1 заголовок');
            }
            if (!Schema::hasColumn('static_pages', 'subtitle')) {
                $table->text('subtitle')->nullable()->after('title')->comment('Описание заголовка');
            }
            if (!Schema::hasColumn('static_pages', 'slug')) {
                $table->string('slug', 100)->unique()->after('subtitle')->comment('Уникальный идентификатор страницы');
            }
            if (!Schema::hasColumn('static_pages', 'content')) {
                $table->text('content')->nullable()->after('slug')->comment('Главный текст страницы');
            }
            if (!Schema::hasColumn('static_pages', 'meta_title')) {
                $table->string('meta_title', 255)->nullable()->after('content')->comment('Meta заголовок для SEO');
            }
            if (!Schema::hasColumn('static_pages', 'meta_description')) {
                $table->text('meta_description')->nullable()->after('meta_title')->comment('Meta описание для SEO');
            }
            if (!Schema::hasColumn('static_pages', 'active')) {
                $table->boolean('active')->default(true)->after('meta_description')->comment('Активна ли страница');
            }
        });
        
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        
        Schema::table('static_pages', function (Blueprint $table) {
            // Удаляем новые поля
            $table->dropColumn(['title', 'subtitle', 'slug', 'content', 'meta_title', 'meta_description', 'active']);
        });
        
        Schema::table('static_pages', function (Blueprint $table) {
            // Восстанавливаем старые поля
            $table->string('page', 100)->unique()->after('id')->comment('Идентификатор страницы (slug)');
            $table->text('description')->nullable()->after('page')->comment('Текст описания');
            $table->string('main_image', 500)->nullable()->after('description')->comment('Путь к главной картинке');
            $table->string('alt_image', 255)->nullable()->after('main_image')->comment('Alt текст для картинки');
        });
        
        Schema::enableForeignKeyConstraints();
    }
};
