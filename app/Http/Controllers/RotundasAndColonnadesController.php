<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Gallery;
use App\Models\MetaTag;
use App\Models\StaticImages;
use App\Models\StaticPage;

class RotundasAndColonnadesController
{
    function rotundas_and_colonnades() {
        $gallery = Gallery::query()->with(['gallery_images'])->latest()->get();
        $rotundas_and_colonnades_images = $gallery->where('type', 'rotundas');
        $metaTags = MetaTag::where('page', 'rotundas_and_colonnades')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Ротонды и колонны';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание ротонд и колонн';
        $categories = Category::where('page', 'rotundas_and_colonnades')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        $static_images = StaticImages::where('page', 'rotundas_and_colonnades')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
            if (str_ends_with($static_image->image, '.webp')) {
                $oldPath = str_replace('.webp', '.png', $static_image->image);
                $static_images_arr[$oldPath] = $static_image->description_image;
            }
        }
        try {
            $staticPage = StaticPage::where('page', 'rotundas_and_colonnades')->first();
        } catch (\Exception $e) {
            $staticPage = null;
        }
        return view('elitvid.site.rotundas_and_colonnades', compact('rotundas_and_colonnades_images', 'metaTitle', 'metaDescription', 'category', 'static_images_arr', 'staticPage'));
    }
}
