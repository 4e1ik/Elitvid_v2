<?php

namespace App\Repositories;

use App\Models\StaticImages;

class StaticImagesRepository
{
    public function getStaticImagesForPage(string $page): array
    {
        $static_images = StaticImages::where('page', $page)->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
        }
        return $static_images_arr;
    }
}
