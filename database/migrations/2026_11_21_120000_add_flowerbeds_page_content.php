<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

// Спека 007: у страницы «Сборные клумбы» должна быть запись в «Контенте страниц», иначе её нечем редактировать в админке.
return new class extends Migration
{
    public function up(): void
    {
        DB::table('page_contents')->insertOrIgnore([
            'page' => 'flowerbeds',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('page_contents')->where('page', 'flowerbeds')->delete();
    }
};
