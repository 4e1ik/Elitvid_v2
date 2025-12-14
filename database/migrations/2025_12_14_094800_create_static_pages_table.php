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
        Schema::create('static_pages', function (Blueprint $table) {
            $table->id();
            $table->string('page', 100)->unique()->comment('Идентификатор страницы (slug)');
            $table->string('title', 500)->nullable()->comment('H1 заголовок');
            $table->text('description')->nullable()->comment('Текст описания');
            $table->string('main_image', 500)->nullable()->comment('Путь к главной картинке');
            $table->string('alt_image', 255)->nullable()->comment('Alt текст для картинки');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('static_pages');
    }
};
