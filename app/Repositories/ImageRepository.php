<?php

namespace App\Repositories;

use App\Models\Image;
use App\Models\Product;

class ImageRepository
{
    // Главная у товара одна: снимает флаг с остальных картинок того же товара.
    public function clearOtherProductMainImages(Image $image): void
    {
        if ($image->imageable_type !== Product::class || !$image->main_image) {
            return;
        }

        Image::where('imageable_type', Product::class)
            ->where('imageable_id', $image->imageable_id)
            ->where('id', '!=', $image->id)
            ->update(['main_image' => false]);
    }
}
