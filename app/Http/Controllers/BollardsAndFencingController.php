<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Gallery;
use App\Models\MetaTag;
use App\Models\StaticImages;
use App\Models\StaticPage;

class BollardsAndFencingController
{
    function bollards_and_fencing() {
        $bollards_and_fencing_images = Gallery::query()
            ->where('type', 'bollards')
            ->with(['gallery_images'])
            ->latest()
            ->get();
        $metaTags = MetaTag::where('page', 'bollards_and_fencing')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Болларды и ограждения';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание боллардов и ограждений';
        $categories = Category::where('page', 'bollards_and_fencing')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;

        // Статические картинки для alt-тегов, нормализуем пути
        $static_images = StaticImages::where('page', 'bollards_and_fencing')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            // убираем ведущие ./ и дублируем варианты путей
            $normalizedPath = ltrim($static_image->image, './');

            // без слеша в начале
            $static_images_arr[$normalizedPath] = $static_image->description_image;

            // со слешем в начале
            if (!str_starts_with($normalizedPath, '/')) {
                $static_images_arr['/' . $normalizedPath] = $static_image->description_image;
            }

            // Дополнительно поддерживаем старый формат .png вместо .webp
            if (str_ends_with($normalizedPath, '.webp')) {
                $oldPath = str_replace('.webp', '.png', $normalizedPath);
                $static_images_arr[$oldPath] = $static_image->description_image;
                if (!str_starts_with($oldPath, '/')) {
                    $static_images_arr['/' . $oldPath] = $static_image->description_image;
                }
            }
        }
        try {
            $staticPage = StaticPage::where('page', 'bollards_and_fencing')->first();
        } catch (\Exception $e) {
            $staticPage = null;
        }
        return view('elitvid.site.bollards_and_fencing', compact('bollards_and_fencing_images', 'metaTitle', 'metaDescription', 'category', 'static_images_arr', 'staticPage'));
    }
}
