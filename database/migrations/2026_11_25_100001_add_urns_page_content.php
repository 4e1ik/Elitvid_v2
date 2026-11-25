<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

// Спека 008: у страницы «Урны» должна быть запись в «Контенте страниц» (SEO-текст, «Примеры работ»).
return new class extends Migration
{
    public function up(): void
    {
        DB::table('page_contents')->insertOrIgnore([
            'page' => 'urns',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('page_contents')->where('page', 'urns')->delete();
    }
};
