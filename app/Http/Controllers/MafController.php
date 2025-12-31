<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Gallery;
use App\Models\MetaTag;
use App\Models\StaticImages;
use App\Models\StaticPage;

class MafController
{
    function small_architectural_forms()
    {
        $gallery = Gallery::query()->with(['gallery_images'])->latest()->get();
        $small_architectural_forms_images = $gallery->where('type', 'maf');
        $metaTags = MetaTag::where('page', 'small_architectural_forms')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Малые архитектурные формы';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание малых архитектурных форм';
        $categories = Category::where('page', 'small_architectural_forms')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        $static_images = StaticImages::where('page', 'small_architectural_forms')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
        }
        try {
            $staticPage = StaticPage::where('page', 'small_architectural_forms')->first();
        } catch (\Exception $e) {
            $staticPage = null;
        }
        return view('elitvid.site.small_architectural_forms', compact('small_architectural_forms_images', 'metaTitle', 'metaDescription', 'category', 'static_images_arr', 'staticPage'));
    }
}
