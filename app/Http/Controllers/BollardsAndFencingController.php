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
        $static_images = StaticImages::where('page', 'bollards_and_fencing')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
            if (str_ends_with($static_image->image, '.webp')) {
                $oldPath = str_replace('.webp', '.png', $static_image->image);
                $static_images_arr[$oldPath] = $static_image->description_image;
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
