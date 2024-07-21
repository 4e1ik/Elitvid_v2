<?php

namespace App\Http\Controllers;

use App\Models\BenchProduct;
use App\Models\Gallery;
use App\Models\PotProduct;

class MainController extends Controller
{
    function index() {
        $gallery = Gallery::query()->with(['gallery_images'])->get();
        $main_page_images = $gallery->where('type', 'main_page');
        return view('elitvid.site.index', compact( 'main_page_images'));
    }

    function bollards_and_fencing() {
        return view('elitvid.site.bollards_and_fencing');
    }

    function facade_stucco_molding_and_panels() {
        return view('elitvid.site.facade_stucco_molding_and_panels');
    }

    function parklets_and_canopies() {
        return view('elitvid.site.parklets_and_canopies');
    }

    function pillars_and_covers() {
        return view('elitvid.site.pillars_and_covers');
    }

    function rotundas_and_colonnades() {
        return view('elitvid.site.rotundas_and_colonnades');
    }

    function about() {
        return view('elitvid.site.about');
    }

    function show_pot_product($id){
        $products = PotProduct::query()->with('pot_images')->where('id', $id)->get();
        $rand_products = PotProduct::query()->with('pot_images')->inRandomOrder()->get();
//        $rand_products = PotProduct::query()->with('pot_images');
        $i = 1;
        $j = 1;

        $rows = [];
        foreach ($products as $product) {
            $p_size = explode("|", $product->size);
            $p_weight = explode("|", $product->weight);
            $p_price = explode("|", $product->price);


            $count = min(count($p_price), count($p_weight), count($p_size));


            for ($key = 0; $key < $count; $key++){
                if ($p_size[$key]){
                    if ($p_weight[$key]){
                        if ($p_price[$key]){
                            $rows[$key] = $p_size[$key].'|'.$p_weight[$key].'|'.$p_price[$key];
                        }
                    }
                }
            }
        }

//        dd($rows);

        $count = count($rows);

//        dd($count);

        return view('elitvid.site.pots.pot_product_page', compact('products', 'i', 'j', 'rows', 'count', 'rand_products'));
    }

    function show_bench_product($id){
        $products = benchProduct::query()->with('bench_images')->where('id', $id)->get();
        $rand_products = benchProduct::query()->with('bench_images')->get();
        $i = 1;
        $j = 1;

        $rows = [];
        foreach ($products as $product) {
            $p_size = explode("|", $product->size);
            $p_weight = explode("|", $product->weight);
            $p_price = explode("|", $product->price);

            $count = min(count($p_price), count($p_weight), count($p_size));


            for ($key = 0; $key < $count; $key++){
                if ($p_size[$key]){
                    if ($p_weight[$key]){
                        if ($p_price[$key]){
                            $rows[$key] = $p_size[$key].'|'.$p_weight[$key].'|'.$p_price[$key];
                        }
                    }
                }
            }
        }

//        dd($rows);

        $count = count($rows);

//        dd($count);

        return view('elitvid.site.benches.bench_product_page', compact('products', 'i', 'j', 'rows', 'count', 'rand_products'));
    }

    function benches() {

        $gallery = Gallery::query()->with(['gallery_images'])->get();
        $benches_images = $gallery->where('type', 'benches');

        return view('elitvid.site.benches', compact('benches_images'));
    }

    function street_furniture_benches() {

        $benches = BenchProduct::query()->whereIn('active', [1])->with(['bench_images'])->get();
        $street_furniture_benches = $benches->where('collection', 'Street_furniture');

        return view('elitvid.site.benches.street_furniture_benches', compact('street_furniture_benches'));
    }

    function verona_benches() {

        $benches = BenchProduct::query()->whereIn('active', [1])->with(['bench_images'])->get();
        $verona_benches = $benches->where('collection', 'Verona');

        return view('elitvid.site.benches.verona_benches', compact('verona_benches'));
    }

    function stones_benches() {

        $benches = BenchProduct::query()->whereIn('active', [1])->with(['bench_images'])->get();
        $stones_benches = $benches->where('collection', 'Stones');

        return view('elitvid.site.benches.stones_benches', compact('stones_benches'));
    }

    function solo_benches() {

        $benches = BenchProduct::query()->whereIn('active', [1])->with(['bench_images'])->get();
        $solo_benches = $benches->where('collection', 'Solo');

        return view('elitvid.site.benches.solo_benches', compact('solo_benches'));
    }

    function lines_benches() {

        $benches = BenchProduct::query()->whereIn('active', [1])->with(['bench_images'])->get();
        $lines_benches = $benches->where('collection', 'lines');

        return view('elitvid.site.benches.lines_benches', compact('lines_benches'));
    }

    function directions() {
        return view('elitvid.site.directions');
    }

    function decorations()
    {
        $gallery = Gallery::query()->with(['gallery_images'])->get();
        $decorative_elements_images = $gallery->where('type', 'decorative_elements');
        return view('elitvid.site.decorations', compact('decorative_elements_images'));
    }

    function pots() {

        $gallery = Gallery::query()->with(['gallery_images'])->get();
        $pots_images = $gallery->where('type', 'pots');

        return view('elitvid.site.pots', compact('pots_images'));
    }

    function rectangular_pots() {
        $pots = PotProduct::query()->whereIn('active', [1])->with(['pot_images'])->get();
        $rectangular_pots = $pots->where('collection', 'Rectangular');
        return view('elitvid.site.pots.rectangular_pots', compact('rectangular_pots'));
    }

    function square_pots() {
        $pots = PotProduct::query()->whereIn('active', [1])->with(['pot_images'])->get();
        $square_pots = $pots->where('collection', 'Square');
        return view('elitvid.site.pots.square_pots', compact('square_pots'));
    }

    function round_pots() {
        $pots = PotProduct::query()->whereIn('active', [1])->with(['pot_images'])->get();
        $round_pots = $pots->where('collection', 'Round');
        return view('elitvid.site.pots.round_pots', compact('round_pots'));
    }
}
