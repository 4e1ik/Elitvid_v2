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
        Schema::table('galleries', function (Blueprint $table) {
            // Оставляем поле type, так как оно активно используется в коде
            // $table->dropColumn(['type']); // Закомментировано, так как type используется в контроллерах
            
            // Добавляем полиморфные поля
            $table->unsignedBigInteger('galleriable_id')->nullable()->after('id')->comment('ID связанной модели');
            $table->string('galleriable_type', 255)->nullable()->after('galleriable_id')->comment('Тип связанной модели');
            
            // Добавляем индекс для полиморфной связи
            $table->index(['galleriable_id', 'galleriable_type'], 'galleries_galleriable_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            // Удаляем полиморфные поля
            $table->dropIndex('galleries_galleriable_index');
            $table->dropColumn(['galleriable_id', 'galleriable_type']);
            
            // Возвращаем старое поле
            $table->text('type')->nullable(false)->after('id');
        });
    }
};
