<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Gallery;
use App\Models\MetaTag;
use App\Models\StaticImages;
use App\Models\StaticPage;

class PillarsAndCoversController
{
    function pillars_and_covers() {
        $columns_and_panels_images = Gallery::query()
            ->where('type', 'columns_and_panels')
            ->with(['gallery_images'])
            ->latest()
            ->get();
        $metaTags = MetaTag::where('page', 'pillars_and_covers')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Столбы и накрывки';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание столбов и накрывок';
        $categories = Category::where('page', 'pillars_and_covers')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        $static_images = StaticImages::where('page', 'pillars_and_covers')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
            if (str_ends_with($static_image->image, '.webp')) {
                $oldPath = str_replace('.webp', '.png', $static_image->image);
                $static_images_arr[$oldPath] = $static_image->description_image;
            }
        }
        try {
            $staticPage = StaticPage::where('page', 'pillars_and_covers')->first();
        } catch (\Exception $e) {
            $staticPage = null;
        }
        return view('elitvid.site.pillars_and_covers', compact('columns_and_panels_images', 'metaTitle', 'metaDescription', 'category', 'static_images_arr', 'staticPage'));
    }
}
