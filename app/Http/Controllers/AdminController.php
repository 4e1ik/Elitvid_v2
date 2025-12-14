<?php

namespace App\Http\Controllers;

use App\Models\BenchProduct;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\MetaTag;
use App\Models\PotProduct;
use App\Models\StaticImages;

class AdminController extends Controller
{
    public function index() {
        return view('elitvid.admin.admin');
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

    public function round_pots(PotProduct $PotProduct) {
        $round_pots = PotProduct::query()->where('collection', 'Round')->latest()->get();

        return view('elitvid.admin.pots.round_pots', compact('round_pots', 'PotProduct'));
    }

    public function rectangular_pots(PotProduct $PotProduct) {
        $rectangular_pots = PotProduct::query()->where('collection', 'Rectangular')->latest()->get();

        return view('elitvid.admin.pots.rectangular_pots', compact( 'rectangular_pots', 'PotProduct'));
    }

    public function square_pots(PotProduct $PotProduct) {
        $square_pots = PotProduct::query()->where('collection','Square')->latest()->get();

        return view('elitvid.admin.pots.square_pots', compact( 'square_pots', 'PotProduct'));
    }

    public function pots_images(Gallery $gallery) {
        $gallery = Gallery::query()->with(['gallery_images'])->latest()->get();
        $pots_images = $gallery->where('type', 'pots');

        return view(
            'elitvid.admin.gallery.pots_images', compact(
                'pots_images','gallery'
            )
        );
    }

    public function benches_images(Gallery $gallery) {
        $gallery = Gallery::query()->with(['gallery_images'])->latest()->get();
        $benches_images = $gallery->where('type', 'benches');

        return view(
            'elitvid.admin.gallery.benches_images', compact(
                'benches_images','gallery'
            )
        );
    }

    public function main_page_images(Gallery $gallery) {
        $gallery = Gallery::query()->with(['gallery_images'])->latest()->get();
        $main_page_images = $gallery->where('type', 'main_page');

        return view(
            'elitvid.admin.gallery.main_page_images', compact(
                'gallery', 'main_page_images'
            )
        );
    }

    public function decorative_elements_images(Gallery $gallery) {
        $gallery = Gallery::query()->with(['gallery_images'])->latest()->get();
        $decorative_elements_images = $gallery->where('type', 'decorative_elements');

        return view(
            'elitvid.admin.gallery.decorative_elements_images', compact(
                'gallery',  'decorative_elements_images'
            )
        );
    }

    public function bollards_images(Gallery $gallery) {
        $gallery = Gallery::query()->with(['gallery_images'])->latest()->get();
        $bollards_images = $gallery->where('type', 'bollards');

        return view(
            'elitvid.admin.gallery.bollards_images', compact(
                'gallery','bollards_images'
            )
        );
    }

    public function parklets_and_naves_images(Gallery $gallery) {
        $gallery = Gallery::query()->with(['gallery_images'])->latest()->get();
        $parklets_and_naves_images = $gallery->where('type', 'parklets_and_naves');

        return view(
            'elitvid.admin.gallery.parklets_and_naves_images', compact(
                'gallery', 'parklets_and_naves_images'
            )
        );
    }

    public function columns_and_panels_images(Gallery $gallery) {
        $gallery = Gallery::query()->with(['gallery_images'])->latest()->get();
        $columns_and_panels_images = $gallery->where('type', 'columns_and_panels');

        return view(
            'elitvid.admin.gallery.columns_and_panels_images', compact(
                'gallery', 'columns_and_panels_images'
            )
        );
    }

    public function facade_walls_images(Gallery $gallery) {
        $gallery = Gallery::query()->with(['gallery_images'])->latest()->get();
        $facade_walls_images = $gallery->where('type', 'facade_walls');

        return view(
            'elitvid.admin.gallery.facade_walls_images', compact(
                'gallery', 'facade_walls_images'
            )
        );
    }

    public function rotundas_images(Gallery $gallery) {
        $gallery = Gallery::query()->with(['gallery_images'])->latest()->get();
        $rotundas_images = $gallery->where('type', 'rotundas');

        return view(
            'elitvid.admin.gallery.rotundas_images', compact(
                'gallery','rotundas_images'
            )
        );
    }

    public function maf_images(Gallery $gallery) {
        $gallery = Gallery::query()->with(['gallery_images'])->latest()->get();
        $maf_images = $gallery->where('type', 'maf');

        return view(
            'elitvid.admin.gallery.maf_images', compact(
                'gallery',  'maf_images'
            )
        );
    }

    public function create($route){

        $route_name = $route;

        if ($route_name == 'gallery'){
            return view('includes.elitvid.admin.create_gallery', compact('route_name'));
        } else if($route_name == 'pots'){
            return view('includes.elitvid.admin.create_pot_product', compact('route_name'));
        } else if($route_name == 'benches'){
            return view('includes.elitvid.admin.create_bench_product', compact('route_name'));
        }

    }

}
