<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\PageContent;
use App\Models\Gallery;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Маппинг страниц на типы галерей
        $pageToGalleryType = [
            'main' => 'main_page',
            'pots' => 'pots',
            'benches' => 'benches',
            'decorations' => 'decorative_elements',
            'bollards_and_fencing' => 'bollards',
        ];

        // Связываем существующие галереи с PageContent через полиморфную связь
        foreach ($pageToGalleryType as $page => $galleryType) {
            $pageContent = PageContent::where('page', $page)->first();
            
            if ($pageContent) {
                // Ищем галерею по типу, которая еще не связана
                $gallery = Gallery::where('type', $galleryType)
                    ->whereNull('galleriable_id')
                    ->first();
                
                // Если нашли галерею и у PageContent еще нет связанной галереи
                if ($gallery && !$pageContent->gallery) {
                    DB::table('galleries')
                        ->where('id', $gallery->id)
                        ->update([
                            'galleriable_id' => $pageContent->id,
                            'galleriable_type' => PageContent::class,
                        ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Отвязываем галереи от PageContent
        DB::table('galleries')
            ->where('galleriable_type', PageContent::class)
            ->update([
                'galleriable_id' => null,
                'galleriable_type' => null,
            ]);
    }
};
