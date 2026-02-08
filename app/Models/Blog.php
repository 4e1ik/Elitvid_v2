<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'main_image', // Оставляем для обратной совместимости со старыми записями
        'content',
        'meta_title',
        'meta_description',
        'active',
    ];

    /**
     * Полиморфная связь с изображениями
     */
    public function images()
    {
        return $this->morphMany(\App\Models\Image::class, 'imageable');
    }

    /**
     * Получить главное изображение (для обратной совместимости)
     * Сначала проверяет связь images, затем старое поле main_image
     */
    public function getMainImageAttribute($value)
    {
        // Если есть изображение через связь, возвращаем его
        $image = $this->images()->where('main_image', true)->first();
        if ($image) {
            return $image->image;
        }

        // Иначе возвращаем старое значение из поля main_image
        return $value;
    }

    /**
     * Проверка наличия главного изображения
     */
    public function hasMainImage(): bool
    {
        $image = $this->images()->where('main_image', true)->first();
        if ($image) {
            return true;
        }
        return !empty($this->attributes['main_image'] ?? null);
    }
}
