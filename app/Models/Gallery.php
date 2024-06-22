<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'active'];

    public function images(){
        return $this->hasMany(Image::class, 'gallery_id', 'id');
    }
}
