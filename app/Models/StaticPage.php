<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaticPage extends Model
{
    protected $table = 'static_pages';

    protected $fillable = [
        'title',
        'subtitle',
        'slug',
        'menu_name',
        'content',
        'meta_title',
        'meta_description',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Полиморфная связь: StaticPage имеет много Gallery
     */
    public function galleries()
    {
        return $this->morphMany(Gallery::class, 'galleriable');
    }

    /**
     * Связь для обратной совместимости
     */
    public function gallery()
    {
        return $this->morphOne(Gallery::class, 'galleriable');
    }

    /**
     * Прямая связь с изображениями (main_image, menu_image)
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}

