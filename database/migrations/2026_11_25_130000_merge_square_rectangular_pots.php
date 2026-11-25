<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Спека 012: квадратные и прямоугольные кашпо — одна коллекция и одна страница.
// Тексты и картинки страницы берутся с «Прямоугольных»; id бывших Square хранятся для отката.
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('pots_square_backup')) {
            Schema::create('pots_square_backup', function (Blueprint $table) {
                $table->unsignedBigInteger('pot_id')->primary();
            });
        }

        DB::transaction(function () {
            DB::table('pots_square_backup')->insertOrIgnore(
                DB::table('pots')->where('collection', 'Square')->pluck('id')->map(fn ($id) => ['pot_id' => $id])->all()
            );
            DB::table('pots')->whereIn('collection', ['Square', 'Rectangular'])->update(['collection' => 'Square_rectangular']);
            DB::table('page_contents')->where('page', 'rectangular_pots')->update(['page' => 'square_rectangular_pots']);
            DB::table('static_images')->where('page', 'rectangular_pots')->update(['page' => 'square_rectangular_pots']);
        });
    }

    public function down(): void
    {
        DB::transaction(function () {
            DB::table('pots')->where('collection', 'Square_rectangular')->update(['collection' => 'Rectangular']);
            if (Schema::hasTable('pots_square_backup')) {
                DB::table('pots')->whereIn('id', DB::table('pots_square_backup')->pluck('pot_id'))->update(['collection' => 'Square']);
            }
            DB::table('page_contents')->where('page', 'square_rectangular_pots')->update(['page' => 'rectangular_pots']);
            DB::table('static_images')->where('page', 'square_rectangular_pots')->update(['page' => 'rectangular_pots']);
        });

        Schema::dropIfExists('pots_square_backup');
    }
};
