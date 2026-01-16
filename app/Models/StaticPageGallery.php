<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaticPageGallery extends Model
{
    protected $table = 'static_page_galleries';

    protected $fillable = [
        'static_galleriable_id',
        'static_galleriable_type',
        'active'
    ];

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function static_galleriable()
    {
        return $this->morphTo();
    }
}
