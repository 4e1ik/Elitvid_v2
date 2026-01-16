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
        Schema::create('static_page_galleries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('static_galleriable_id')->comment('ID связанной модели');
            $table->string('static_galleriable_type', 255)->comment('Тип связанной модели');
            $table->boolean('active')->default(true)->comment('Активна ли галерея');
            $table->timestamps();
            
            $table->index(['static_galleriable_id', 'static_galleriable_type'], 'spg_galleriable_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('static_page_galleries');
    }
};
