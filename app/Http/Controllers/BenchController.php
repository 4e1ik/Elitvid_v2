<?php

namespace App\Http\Controllers;

use App\Models\BenchProduct;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\MetaTag;
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

        $benches = BenchProduct::query()->whereIn('active', [1])->with(['bench_images'])->latest()->get();
        $street_furniture_benches = $benches->where('collection', 'Street_furniture');
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
        return view('elitvid.site.benches.street_furniture_benches', compact('street_furniture_benches', 'metaTitle', 'metaDescription', 'category', 'static_images_arr'));
    }

    function verona_benches() {

        $benches = BenchProduct::query()->whereIn('active', [1])->with(['bench_images'])->latest()->get();
        $verona_benches = $benches->where('collection', 'Verona');
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
        return view('elitvid.site.benches.verona_benches', compact('verona_benches', 'metaTitle', 'metaDescription', 'category', 'static_images_arr'));
    }

    function stones_benches() {

        $benches = BenchProduct::query()->whereIn('active', [1])->with(['bench_images'])->latest()->get();
        $stones_benches = $benches->where('collection', 'Stones');
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
        return view('elitvid.site.benches.stones_benches', compact('stones_benches', 'metaTitle', 'metaDescription', 'category', 'static_images_arr'));
    }

    function solo_benches() {

        $benches = BenchProduct::query()->whereIn('active', [1])->with(['bench_images'])->latest()->get();
        $solo_benches = $benches->where('collection', 'Solo');
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
        return view('elitvid.site.benches.solo_benches', compact('solo_benches', 'metaTitle', 'metaDescription', 'category', 'static_images_arr'));
    }

    function lines_benches() {

        $benches = BenchProduct::query()->whereIn('active', [1])->with(['bench_images'])->latest()->get();
        $lines_benches = $benches->where('collection', 'lines');
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
        return view('elitvid.site.benches.lines_benches', compact('lines_benches', 'metaTitle', 'metaDescription', 'category', 'static_images_arr'));
    }

    function show_bench_product($collection, $id){
        $products = benchProduct::query()->with('bench_images')->where('id', $id)->latest()->get();
        $rand_products = benchProduct::query()->with('bench_images')->where('active', '1')->inRandomOrder()->get();
        $i = 1;
        $j = 1;

        $rows = [];
        $arr_size = ['','','','',''];
        $arr_weight = ['','','','',''];
        $arr_price = ['','','','',''];
        foreach ($products as $product) {
            $p_size = explode("|", $product->size);
            $p_weight = explode("|", $product->weight);
            $p_price = explode("|", $product->price);

            for($i=0;$i<5;$i++){
                if(empty($p_size[$i])) {
                    $arr_size[$i] = '';
                }  else {
                    $arr_size[$i] = $p_size[$i];
                }

                if(empty($p_weight[$i])){
                    $arr_weight[$i] = '';
                }  else {
                    $arr_weight[$i] = $p_weight[$i];
                }

                if(empty($p_price[$i])){
                    $arr_price[$i] = '';
                }  else {
                    $arr_price[$i] = $p_price[$i];
                }
                $rows[$i] = (empty($product->size) ? '' : $arr_size[$i]).'|'.(empty($product->weight) ? '' : $arr_weight[$i]).'|'.(empty($product->price) ? '' : $arr_price[$i]);
            }
        }

        $count = count($rows);

        $metaTitle = $products->first()?->meta_title ?? 'Товар';
        $metaDescription = $products->first()?->meta_description ?? 'Описание товара';
        $static_images = StaticImages::where('page', 'bench_product_page')->get();
        $static_images_arr = [];
        $canonicalUrl = route('show_bench_product', ['collection' => $collection,'id' => $id]);
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
        }
        return view('elitvid.site.benches.bench_product_page',
            compact('products',
                'i',
                'j',
                'rows',
                'count',
                'rand_products',
                'metaTitle',
                'metaDescription',
                'static_images_arr',
                'canonicalUrl',
            ));
    }
}
