<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Gallery;
use App\Models\MetaTag;
use App\Models\StaticImages;
use App\Models\StaticPage;

class FacadeStuccoMoldingAndPanelsController
{
    function facade_stucco_molding_and_panels() {
        $gallery = Gallery::query()->with(['gallery_images'])->latest()->get();
        $facade_walls_images = $gallery->where('type', 'facade_walls');
        $metaTags = MetaTag::where('page', 'facade_stucco_molding_and_panels')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Фасадная лепнина и панели';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание фасадной лепнины и панелей';
        $categories = Category::where('page', 'facade_stucco_molding_and_panels')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        $static_images = StaticImages::where('page', 'facade_stucco_molding_and_panels')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
        }
        try {
            $staticPage = StaticPage::where('page', 'facade_stucco_molding_and_panels')->first();
        } catch (\Exception $e) {
            $staticPage = null;
        }
        return view('elitvid.site.facade_stucco_molding_and_panels', compact('facade_walls_images', 'metaTitle', 'metaDescription', 'category', 'static_images_arr', 'staticPage'));
    }
}
