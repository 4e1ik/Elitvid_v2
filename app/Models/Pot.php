<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pot extends Model
{
    protected $table = 'pots';

    protected $fillable = [
        'product_id',
        'data',
        'material',
        'collection'
    ];

    protected $casts = [
        'data' => 'array', // Laravel автоматически преобразует JSON ↔ массив
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
