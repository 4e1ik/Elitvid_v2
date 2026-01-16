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

    public function static_gallery()
    {
        return $this->morphMany(StaticPageGallery::class, 'static_galleriable');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}

