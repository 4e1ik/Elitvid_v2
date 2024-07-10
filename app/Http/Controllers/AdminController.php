<?php

namespace App\Http\Controllers;

use App\Models\BenchProduct;
use App\Models\Gallery;
use App\Models\PotProduct;

class AdminController extends Controller
{
    function index() {
        return view('elitvid.admin.admin');
    }

    function catalog() {
        return view('elitvid.admin.catalog');
    }

    function benches(BenchProduct $benchProduct) {

        $benches = BenchProduct::query()->whereIn('collection', ['Verona', 'Stones', 'lines', 'Solo', 'Street_furniture'])->get();
//        dd($benches);
        $benches_verona = BenchProduct::query()->where('collection', 'Verona')->get();
        $benches_stones = BenchProduct::query()->where('collection', 'Stones')->get();
        $benches_solo = BenchProduct::query()->where('collection', 'Solo')->get();
        $benches_lines = BenchProduct::query()->where('collection', 'lines')->get();
        $benches_street_furniture = BenchProduct::query()->where('collection', 'Street_furniture')->get();
        return view('elitvid.admin.benches.benches',
            compact('benches_stones', 'benches_lines', 'benches_solo', 'benches_street_furniture', 'benches_verona','benches')
        );
    }

    function pots(PotProduct $PotProduct) {
        $round_pots = PotProduct::query()->where('collection', 'Round')->get();
        $rectangular_pots = PotProduct::query()->where('collection', 'Rectangular')->get();
        $square_pots = PotProduct::query()->where('collection','Square')->get();

        return view('elitvid.admin.pots.pots', compact('round_pots', 'rectangular_pots', 'square_pots', 'PotProduct'));
    }

    function gallery(Gallery $gallery) {
        $gallery = Gallery::query()->with(['gallery_images'])->get();
        $pots_images = $gallery->where('type', 'pots');
        $benches_images = $gallery->where('type', 'benches');
        $main_page_images = $gallery->where('type', 'main_page');
        $decorative_elements_images = $gallery->where('type', 'decorative_elements');
        $bollards_images = $gallery->where('type', 'bollards');
        $parklets_and_naves_images = $gallery->where('type', 'parklets_and_naves');
        $columns_and_panels_images = $gallery->where('type', 'columns_and_panels');
        $facade_walls_images = $gallery->where('type', 'facade_walls');
        $rotundas_images = $gallery->where('type', 'rotundas');

        return view(
            'elitvid.admin.gallery', compact(
                'pots_images','benches_images','gallery', 'main_page_images',  'decorative_elements_images', 'bollards_images', 'parklets_and_naves_images', 'columns_and_panels_images', 'facade_walls_images', 'rotundas_images'
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
