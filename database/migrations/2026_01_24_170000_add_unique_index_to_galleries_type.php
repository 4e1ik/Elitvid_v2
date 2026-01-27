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
        // Сначала изменяем тип поля type на VARCHAR, если оно TEXT
        // Это необходимо для создания уникального индекса в MySQL
        Schema::table('galleries', function (Blueprint $table) {
            if (Schema::hasColumn('galleries', 'type')) {
                $table->string('type', 255)->nullable()->change();
            }
        });
        
        // Теперь добавляем уникальный индекс
        Schema::table('galleries', function (Blueprint $table) {
            // Добавляем уникальный индекс на поле type, чтобы для каждого типа была только одна галерея
            // ВАЖНО: Эта миграция должна выполняться ПОСЛЕ consolidate_galleries_by_type
            try {
                $table->unique('type', 'galleries_type_unique');
            } catch (\Exception $e) {
                // Если индекс уже существует или есть дубликаты, пропускаем
                // Дубликаты должны быть удалены предыдущей миграцией
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            try {
                $table->dropUnique('galleries_type_unique');
            } catch (\Exception $e) {
                // Игнорируем ошибку, если индекс не существует
            }
        });
        
        // Возвращаем тип поля обратно в TEXT (опционально)
        Schema::table('galleries', function (Blueprint $table) {
            if (Schema::hasColumn('galleries', 'type')) {
                $table->text('type')->nullable()->change();
            }
        });
    }
};
