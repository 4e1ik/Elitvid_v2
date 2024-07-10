<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'active'];

    public function gallery_images(){
        return $this->hasMany(GalleryImage::class, 'gallery_image_id', 'id');
    }
}
