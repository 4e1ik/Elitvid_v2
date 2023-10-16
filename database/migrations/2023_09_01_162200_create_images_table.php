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
            $table->unsignedBigInteger ('post_id')->nullable('true');
            $table->foreign ('post_id')->references('id')->on('posts')->onDelete('cascade')->onUpdate('cascade');
            $table->string ('image', 255)->nullable('true');
            $table->text ('description_img')->nullable('true');
            $table->integer ('type_img')->nullable('true');
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
