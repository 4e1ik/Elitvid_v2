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
        Schema::table('bench_products', function (Blueprint $table) {
            $table->string ('material', '255')->nullable('true')->change();
            $table->string ('size','255')->nullable('true')->change();
            $table->string ('weight','255')->nullable('true')->change();
            $table->string ('price', '255')->nullable('true')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bench_products', function (Blueprint $table) {
            //
        });
    }
};
