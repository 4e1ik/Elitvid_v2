<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BenchProduct;
use App\Models\BenchImage;
use App\Models\Blog;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\MetaTag;
use App\Models\PotProduct;
use App\Models\PotImage;
use App\Models\StaticImages;
use App\Models\StaticPage;

class AdminController extends Controller
{
    public function index() {
        $stats = [
            'blog_posts' => Blog::count(),
            'active_blog_posts' => Blog::where('active', 1)->count(),
            'bench_products' => BenchProduct::count(),
            'active_bench_products' => BenchProduct::where('active', 1)->count(),
            'pot_products' => PotProduct::count(),
            'active_pot_products' => PotProduct::where('active', 1)->count(),
            'galleries' => Gallery::count(),
            'gallery_images' => GalleryImage::count(),
            'bench_images' => BenchImage::count(),
            'pot_images' => PotImage::count(),
            'static_pages' => StaticPage::count(),
            'static_images' => StaticImages::count(),
        ];

        $recent_blogs = Blog::latest()->take(5)->get();

        // Данные для графиков - последние 6 месяцев
        $months = [];
        $blog_data = [];
        $products_data = [];
        $images_data = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthName = $date->format('M');
            $months[] = $monthName;

            $startOfMonth = $date->copy()->startOfMonth();
            $endOfMonth = $date->copy()->endOfMonth();

            $blog_data[] = Blog::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
            $products_data[] = BenchProduct::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count() +
                              PotProduct::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
            $images_data[] = GalleryImage::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count() +
                            BenchImage::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count() +
                            PotImage::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        }

        // Данные для круговой диаграммы (распределение по типам)
        $chart_data = [
            'months' => $months,
            'blog' => $blog_data,
            'products' => $products_data,
            'images' => $images_data,
            'distribution' => [
                'blog' => $stats['blog_posts'],
                'bench_products' => $stats['bench_products'],
                'pot_products' => $stats['pot_products'],
                'galleries' => $stats['galleries'],
            ]
        ];

        return view('elitvid.admin.admin', compact('stats', 'recent_blogs', 'chart_data'));
    }

    public function static_images($page) {
        $static_images = StaticImages::where('page', $page)->get();
        return view('elitvid.admin.static_images.index', compact('static_images'));
    }

    public function blog_posts()
    {
        $blog_posts = Blog::all();
        return view('elitvid.admin.blog.blog_posts', compact('blog_posts'));
    }

    public function metaTags()
    {
        $metaTags = MetaTag::all();
        return view('elitvid.admin.meta_tags', compact('metaTags'));
    }

    public function benches_verona(BenchProduct $benchProduct) {

        $benches = BenchProduct::query()->whereIn('collection', ['Verona'])->latest()->get();
        $benches_verona = BenchProduct::query()->where('collection', 'Verona')->latest()->get();
        return view('elitvid.admin.benches.benches_verona',
            compact( 'benches_verona','benches')
        );
    }

    public function benches_stones(BenchProduct $benchProduct) {

        $benches = BenchProduct::query()->whereIn('collection', ['Stones'])->latest()->get();
        $benches_stones = BenchProduct::query()->where('collection', 'Stones')->latest()->get();
        return view('elitvid.admin.benches.benches_stones',
            compact('benches_stones','benches')
        );
    }

    public function benches_solo(BenchProduct $benchProduct) {

        $benches = BenchProduct::query()->whereIn('collection', ['Solo'])->latest()->get();
        $benches_solo = BenchProduct::query()->where('collection', 'Solo')->latest()->get();
        return view('elitvid.admin.benches.benches_solo',
            compact('benches_solo','benches')
        );
    }

    public function benches_lines(BenchProduct $benchProduct) {

        $benches = BenchProduct::query()->whereIn('collection', ['lines'])->latest()->get();
        $benches_lines = BenchProduct::query()->where('collection', 'lines')->latest()->get();
        return view('elitvid.admin.benches.benches_lines',
            compact('benches_lines', 'benches')
        );
    }

    public function benches_street_furniture(BenchProduct $benchProduct) {

        $benches = BenchProduct::query()->whereIn('collection', ['Street_furniture'])->latest()->get();
        $benches_street_furniture = BenchProduct::query()->where('collection', 'Street_furniture')->latest()->get();
        return view('elitvid.admin.benches.benches_street_furniture',
            compact('benches_street_furniture', 'benches')
        );
    }

    public function pots_images(Gallery $gallery) {
        $pots_images = Gallery::query()
            ->where('type', 'pots')
            ->with(['gallery_images'])
            ->latest()
            ->get();

        return view(
            'elitvid.admin.gallery.pots_images', compact(
                'pots_images','gallery'
            )
        );
    }

    public function benches_images(Gallery $gallery) {
        $benches_images = Gallery::query()
            ->where('type', 'benches')
            ->with(['gallery_images'])
            ->latest()
            ->get();

        return view(
            'elitvid.admin.gallery.benches_images', compact(
                'benches_images','gallery'
            )
        );
    }

    public function main_page_images(Gallery $gallery) {
        $main_page_images = Gallery::query()
            ->where('type', 'main_page')
            ->with(['gallery_images'])
            ->latest()
            ->get();

        return view(
            'elitvid.admin.gallery.main_page_images', compact(
                'gallery', 'main_page_images'
            )
        );
    }

    public function decorative_elements_images(Gallery $gallery) {
        $decorative_elements_images = Gallery::query()
            ->where('type', 'decorative_elements')
            ->with(['gallery_images'])
            ->latest()
            ->get();

        return view(
            'elitvid.admin.gallery.decorative_elements_images', compact(
                'gallery',  'decorative_elements_images'
            )
        );
    }

    public function bollards_images(Gallery $gallery) {
        $bollards_images = Gallery::query()
            ->where('type', 'bollards')
            ->with(['gallery_images'])
            ->latest()
            ->get();

        return view(
            'elitvid.admin.gallery.bollards_images', compact(
                'gallery','bollards_images'
            )
        );
    }

    public function parklets_and_naves_images(Gallery $gallery) {
        $parklets_and_naves_images = Gallery::query()
            ->where('type', 'parklets_and_naves')
            ->with(['gallery_images'])
            ->latest()
            ->get();

        return view(
            'elitvid.admin.gallery.parklets_and_naves_images', compact(
                'gallery', 'parklets_and_naves_images'
            )
        );
    }

    public function columns_and_panels_images(Gallery $gallery) {
        $columns_and_panels_images = Gallery::query()
            ->where('type', 'columns_and_panels')
            ->with(['gallery_images'])
            ->latest()
            ->get();

        return view(
            'elitvid.admin.gallery.columns_and_panels_images', compact(
                'gallery', 'columns_and_panels_images'
            )
        );
    }

    public function facade_walls_images(Gallery $gallery) {
        $facade_walls_images = Gallery::query()
            ->where('type', 'facade_walls')
            ->with(['gallery_images'])
            ->latest()
            ->get();

        return view(
            'elitvid.admin.gallery.facade_walls_images', compact(
                'gallery', 'facade_walls_images'
            )
        );
    }

    public function rotundas_images(Gallery $gallery) {
        $rotundas_images = Gallery::query()
            ->where('type', 'rotundas')
            ->with(['gallery_images'])
            ->latest()
            ->get();

        return view(
            'elitvid.admin.gallery.rotundas_images', compact(
                'gallery','rotundas_images'
            )
        );
    }

    public function maf_images(Gallery $gallery) {
        $maf_images = Gallery::query()
            ->where('type', 'maf')
            ->with(['gallery_images'])
            ->latest()
            ->get();

        return view(
            'elitvid.admin.gallery.maf_images', compact(
                'gallery',  'maf_images'
            )
        );
    }

    public function concrete_products_images(Gallery $gallery) {
        $concrete_products_images = Gallery::query()
            ->where('type', 'concrete_products')
            ->with(['gallery_images'])
            ->latest()
            ->get();

        return view(
            'elitvid.admin.gallery.concrete_products_images', compact(
                'gallery', 'concrete_products_images'
            )
        );
    }

    public function create($route){

        $route_name = $route;

        if ($route_name == 'gallery'){
            return view('includes.elitvid.admin.create_gallery', compact('route_name'));
        } else if($route_name == 'pots'){
            $productType = 'pot';
            return view('includes.elitvid.admin.create_product', compact('productType'));
        } else if($route_name == 'benches'){
            $productType = 'bench';
            return view('includes.elitvid.admin.create_product', compact('productType'));
        }

    }

}
