<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Urn extends Model
{
    protected $fillable = [
        'product_id',
        'data',
        'material',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
