<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

// Спека 013: у заполненных товаров главная — пористая «слоновая кость».
return new class extends Migration
{
    private const PRODUCT = 'App\\Models\\Product';

    public function up(): void
    {
        $mainIds = DB::table('images')
            ->where('imageable_type', self::PRODUCT)
            ->where('color', 'ivory')
            ->where('texture', 'porous')
            ->groupBy('imageable_id')
            ->selectRaw('MIN(id) as id, imageable_id')
            ->get();

        foreach ($mainIds as $row) {
            DB::table('images')
                ->where('imageable_type', self::PRODUCT)
                ->where('imageable_id', $row->imageable_id)
                ->update(['main_image' => DB::raw('id = ' . (int) $row->id)]);
        }
    }

    public function down(): void
    {
        DB::table('images')
            ->where('imageable_type', self::PRODUCT)
            ->update(['main_image' => false]);
    }
};
