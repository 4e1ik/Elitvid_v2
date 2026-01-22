<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = ['galleriable_id', 'galleriable_type', 'active'];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Полиморфная связь: Gallery может принадлежать любой модели
     */
    public function galleriable()
    {
        return $this->morphTo();
    }

    /**
     * Полиморфная связь: Gallery имеет много Image
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * Старая связь для обратной совместимости (если используется)
     */
    public function gallery_images(){
        return $this->hasMany(GalleryImage::class, 'gallery_image_id', 'id');
    }
}
