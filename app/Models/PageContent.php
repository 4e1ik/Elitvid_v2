<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'page',
        'meta_title',
        'meta_description',
        'category_description',
    ];

    /**
     * Полиморфная связь: PageContent имеет одну Gallery
     */
    public function gallery()
    {
        return $this->morphOne(Gallery::class, 'galleriable');
    }

    /**
     * Получить галерею по типу (для обратной совместимости со старыми галереями)
     */
    public function getGalleryByType()
    {
        // Сначала пытаемся получить через полиморфную связь
        if ($this->gallery) {
            return $this->gallery;
        }

        // Если нет, пытаемся найти по типу страницы
        $galleryType = $this->getGalleryTypeByPage();
        if ($galleryType) {
            return Gallery::where('type', $galleryType)->first();
        }

        return null;
    }

    /**
     * Маппинг страниц на типы галерей (для обратной совместимости)
     */
    private function getGalleryTypeByPage(): ?string
    {
        $mapping = [
            'main' => 'main_page',
            'pots' => 'pots',
            'benches' => 'benches',
            'decorations' => 'decorative_elements',
            'bollards_and_fencing' => 'bollards',
        ];

        return $mapping[$this->page] ?? null;
    }
}
