<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Gallery;
use App\Models\MetaTag;
use App\Models\StaticImages;
use App\Models\StaticPage;

class ConcreteProductsController
{
    function concrete_products() {
        $gallery = Gallery::query()->with(['gallery_images'])->latest()->get();
        $concrete_products_images = $gallery->where('type', 'concrete_products');
        $metaTags = MetaTag::where('page', 'concrete_products')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Изделия из бетона';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание описание изделий из бетона';
        $categories = Category::where('page', 'concrete_products')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        $static_images = StaticImages::where('page', 'concrete_products')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
        }
        try {
            $staticPage = StaticPage::where('page', 'concrete_products')->first();
        } catch (\Exception $e) {
            $staticPage = null;
        }
        return view('elitvid.site.concrete_products', compact('concrete_products_images', 'metaTitle', 'metaDescription', 'category', 'static_images_arr', 'staticPage'));
    }
}
