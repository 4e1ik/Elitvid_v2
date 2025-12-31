<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Gallery;
use App\Models\MetaTag;
use App\Models\StaticImages;
use App\Models\StaticPage;

class ParkletsAndCanopiesController
{
    function parklets_and_canopies() {
        $gallery = Gallery::query()->with(['gallery_images'])->latest()->get();
        $parklets_and_naves_images = $gallery->where('type', 'parklets_and_naves');
        $metaTags = MetaTag::where('page', 'parklets_and_canopies')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Парклеты и навесы';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание парклетов и навесов';
        $categories = Category::where('page', 'parklets_and_canopies')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        $static_images = StaticImages::where('page', 'parklets_and_canopies')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
        }
        try {
            $staticPage = StaticPage::where('page', 'parklets_and_canopies')->first();
        } catch (\Exception $e) {
            $staticPage = null;
        }
        return view('elitvid.site.parklets_and_canopies',compact('parklets_and_naves_images', 'metaTitle', 'metaDescription', 'category', 'static_images_arr', 'staticPage'));
    }
}
