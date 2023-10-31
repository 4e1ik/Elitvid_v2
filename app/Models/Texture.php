<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Texture extends Model
{
    use HasFactory;

    protected $fillable = ['texture_name', 'type', 'active'];

    public function images(){
        return $this->hasMany(Image::class, 'texture_id', 'id');
    }
}
