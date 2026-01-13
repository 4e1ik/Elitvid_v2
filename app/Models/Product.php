<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";

    protected $fillable = [
        'name',
        'active',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function bench()
    {
        return $this->hasOne(Bench::class, 'product_id', 'id');
    }

    public function pot()
    {
        return $this->hasOne(Pot::class, 'product_id', 'id');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
