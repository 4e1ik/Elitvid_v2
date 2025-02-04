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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string ('title', '255')->nullable('false');
            $table->string ('description', '255')->nullable('false');
            $table->string ('main_image', 255)->nullable('false');
            $table->longText ('content')->nullable('true');
            $table->string ('meta_title', '255')->nullable('true');
            $table->text ('meta_description')->nullable('true');
            $table->boolean ('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
