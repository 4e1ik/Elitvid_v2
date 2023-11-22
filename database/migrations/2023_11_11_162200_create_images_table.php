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
        Schema::create('images', function (Blueprint $table) {
            $table->id ();
            $table->unsignedBigInteger ('product_id')->nullable('true');
            $table->foreign ('product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger ('texture_id')->nullable('true');
            $table->foreign ('texture_id')->references('id')->on('textures')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger ('gallery_id')->nullable('true');
            $table->foreign ('gallery_id')->references('id')->on('galleries')->onDelete('cascade')->onUpdate('cascade');
            $table->string ('image', 255)->nullable('true');
            $table->text ('description_image')->nullable('true');
            $table->text ('color')->nullable('true');
            $table->timestamps ();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
