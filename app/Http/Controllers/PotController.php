<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Gallery;
use App\Models\MetaTag;
use App\Models\Product;
use App\Models\StaticImages;
use App\Models\StaticPage;

class PotController
{
    function pots() {
        $static_pages = StaticPage::all();
        $pots_images = Gallery::query()
            ->where('type', 'pots')
            ->with(['gallery_images'])
            ->latest()
            ->get();
        $metaTags = MetaTag::where('page', 'pots')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Кашпо';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание кашпо';
        $categories = Category::where('page', 'pots')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        $static_images = StaticImages::where('page', 'pots')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
            if (str_ends_with($static_image->image, '.webp')) {
                $oldPath = str_replace('.webp', '.png', $static_image->image);
                $static_images_arr[$oldPath] = $static_image->description_image;
            }
        }
        return view('elitvid.site.pots', compact('pots_images', 'metaTitle', 'metaDescription', 'category', 'static_images_arr', 'static_pages'));
    }

    function rectangular_pots() {
        $static_pages = StaticPage::all();
        $products = Product::whereIn('active', [1])
            ->whereHas('pot', function ($query) {
                $query->where('collection', 'Rectangular');
            })
            ->with(['images', 'pot'])
            ->latest()
            ->get();

        $metaTags = MetaTag::where('page', 'rectangular_pots')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Прямоугольные кашпо';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание прямоугольных кашпо';
        $categories = Category::where('page', 'rectangular_pots')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        $static_images = StaticImages::where('page', 'rectangular_pots')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
            if (str_ends_with($static_image->image, '.webp')) {
                $oldPath = str_replace('.webp', '.png', $static_image->image);
                $static_images_arr[$oldPath] = $static_image->description_image;
            }
        }
        return view('elitvid.site.pots.rectangular_pots', compact('products', 'metaTitle', 'metaDescription', 'category', 'static_images_arr', 'static_pages'));
    }

    function square_pots() {
        $static_pages = StaticPage::all();
        $products = Product::whereIn('active', [1])
            ->whereHas('pot', function ($query) {
                $query->where('collection', 'Square');
            })
            ->with(['images', 'pot'])
            ->latest()
            ->get();

        $metaTags = MetaTag::where('page', 'square_pots')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Квадратные кашпо';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание квадратных кашпо';
        $categories = Category::where('page', 'square_pots')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        $static_images = StaticImages::where('page', 'square_pots')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
            if (str_ends_with($static_image->image, '.webp')) {
                $oldPath = str_replace('.webp', '.png', $static_image->image);
                $static_images_arr[$oldPath] = $static_image->description_image;
            }
        }
        return view('elitvid.site.pots.square_pots', compact('products', 'metaTitle', 'metaDescription', 'category', 'static_images_arr', 'static_pages'));
    }

    function round_pots() {
        $static_pages = StaticPage::all();
        $products = Product::whereIn('active', [1])
            ->whereHas('pot', function ($query) {
                $query->where('collection', 'Round');
            })
            ->with(['images', 'pot'])
            ->latest()
            ->get();

        $metaTags = MetaTag::where('page', 'round_pots')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Круглые кашпо';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание круглых кашпо';
        $categories = Category::where('page', 'round_pots')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        $static_images = StaticImages::where('page', 'round_pots')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
            if (str_ends_with($static_image->image, '.webp')) {
                $oldPath = str_replace('.webp', '.png', $static_image->image);
                $static_images_arr[$oldPath] = $static_image->description_image;
            }
        }
        return view('elitvid.site.pots.round_pots', compact('products', 'metaTitle', 'metaDescription', 'category', 'static_images_arr', 'static_pages'));
    }

    function show_pot_product($collection, $id){
        $static_pages = StaticPage::all();
        $product = Product::whereId($id)->with(['images', 'pot'])->first();
        $rand_products = Product::whereIn('active', [1])
            ->whereHas('pot', function ($query) use ($product) {
                $query->where('collection', $product->pot->collection);
            })
            ->with(['images'])
            ->inRandomOrder()
            ->get();
        $metaTitle = $product?->meta_title ?? 'Товар';
        $metaDescription = $product?->meta_description ?? 'Описание товара';
        $static_images = StaticImages::where('page', 'pot_product_page')->get();
        $static_images_arr = [];
        $canonicalUrl = route('show_pot_product', ['collection' => $collection,'id' => $id]);
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
            if (str_ends_with($static_image->image, '.webp')) {
                $oldPath = str_replace('.webp', '.png', $static_image->image);
                $static_images_arr[$oldPath] = $static_image->description_image;
            }
        }
        return view('elitvid.site.pots.pot_product_page',
            compact('product',
                'rand_products',
                'metaTitle',
                'metaDescription',
                'static_images_arr',
                'canonicalUrl',
                'static_pages'
            ));
    }
}
