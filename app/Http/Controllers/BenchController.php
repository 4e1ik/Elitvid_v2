<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Gallery;
use App\Models\MetaTag;
use App\Models\Product;
use App\Models\StaticImages;

class BenchController
{
    function benches() {

        $gallery = Gallery::query()->with(['gallery_images'])->latest()->get();
        $benches_images = $gallery->where('type', 'benches');
        $metaTags = MetaTag::where('page', 'benches')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Скамейки';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание скамеек';
        $categories = Category::where('page', 'benches')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        $static_images = StaticImages::where('page', 'benches')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
        }
        return view('elitvid.site.benches', compact('benches_images', 'metaTitle', 'metaDescription', 'category', 'static_images_arr'));
    }

    function street_furniture_benches() {

        $products = Product::whereIn('active', [1])
            ->whereHas('bench', function ($query) {
                $query->where('collection', 'Street_furniture');
            })
            ->with(['images', 'bench'])
            ->latest()
            ->get();

        $metaTags = MetaTag::where('page', 'street_furniture_benches')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Коллекция Street Furniture';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание коллекции Street Furniture';
        $categories = Category::where('page', 'street_furniture_benches')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        $static_images = StaticImages::where('page', 'street_furniture_benches')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
        }
        return view('elitvid.site.benches.street_furniture_benches', compact('products', 'metaTitle', 'metaDescription', 'category', 'static_images_arr'));
    }

    function verona_benches() {

        $products = Product::whereIn('active', [1])
            ->whereHas('bench', function ($query) {
                $query->where('collection', 'Verona');
            })
            ->with(['images', 'bench'])
            ->latest()
            ->get();

        $metaTags = MetaTag::where('page', 'verona_benches')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Коллекция Verona';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание коллекции Verona';
        $categories = Category::where('page', 'verona_benches')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        $static_images = StaticImages::where('page', 'verona_benches')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
        }
        return view('elitvid.site.benches.verona_benches', compact('products', 'metaTitle', 'metaDescription', 'category', 'static_images_arr'));
    }

    function stones_benches() {

        $products = Product::whereIn('active', [1])
            ->whereHas('bench', function ($query) {
                $query->where('collection', 'Stones');
            })
            ->with(['images', 'bench'])
            ->latest()
            ->get();

        $metaTags = MetaTag::where('page', 'stones_benches')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Коллекция Stones';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание коллекции Stones';
        $categories = Category::where('page', 'stones_benches')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        $static_images = StaticImages::where('page', 'stones_benches')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
        }
        return view('elitvid.site.benches.stones_benches', compact('products', 'metaTitle', 'metaDescription', 'category', 'static_images_arr'));
    }

    function solo_benches() {

        $products = Product::whereIn('active', [1])
            ->whereHas('bench', function ($query) {
                $query->where('collection', 'Solo');
            })
            ->with(['images', 'bench'])
            ->latest()
            ->get();

        $metaTags = MetaTag::where('page', 'solo_benches')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Коллекция Solo';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание коллекции Solo';
        $categories = Category::where('page', 'solo_benches')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        $static_images = StaticImages::where('page', 'solo_benches')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
        }
        return view('elitvid.site.benches.solo_benches', compact('products', 'metaTitle', 'metaDescription', 'category', 'static_images_arr'));
    }

    function lines_benches() {

        $products = Product::whereIn('active', [1])
            ->whereHas('bench', function ($query) {
                $query->where('collection', 'lines');
            })
            ->with(['images', 'bench'])
            ->latest()
            ->get();

        $metaTags = MetaTag::where('page', 'lines_benches')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Коллекция Lines';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание коллекции Lines';
        $categories = Category::where('page', 'lines_benches')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        $static_images = StaticImages::where('page', 'lines_benches')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
        }
        return view('elitvid.site.benches.lines_benches', compact('products', 'metaTitle', 'metaDescription', 'category', 'static_images_arr'));
    }

    function show_bench_product($collection, $id){
        $product = Product::whereId($id)->with(['images', 'bench'])->first();
        $rand_products = Product::whereIn('active', [1])
            ->whereHas('bench', function ($query) use ($product) {
                $query->where('collection', $product->bench->collection);
            })
            ->with(['images'])
            ->inRandomOrder()
            ->get();
        $metaTitle = $product?->meta_title ?? 'Товар';
        $metaDescription = $product?->meta_description ?? 'Описание товара';
        $static_images = StaticImages::where('page', 'bench_product_page')->get();
        $static_images_arr = [];
        $canonicalUrl = route('show_bench_product', ['collection' => $collection,'id' => $id]);
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
        }
        return view('elitvid.site.benches.bench_product_page',
            compact('product',
                'rand_products',
                'metaTitle',
                'metaDescription',
                'static_images_arr',
                'canonicalUrl'
            ));
    }
}
