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
        Schema::create('gallery_images', function (Blueprint $table) {
            $table->id ();
            $table->unsignedBigInteger ('gallery_image_id')->nullable('true');
            $table->foreign ('gallery_image_id')->references('id')->on('galleries')->onDelete('cascade')->onUpdate('cascade');
            $table->string ('image', 255)->nullable('true');
            $table->text ('description_image')->nullable('true');
            $table->timestamps ();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery_images');
    }
};
