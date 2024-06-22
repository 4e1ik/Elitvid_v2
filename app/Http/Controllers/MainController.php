<?php

namespace App\Http\Controllers;

use App\Models\BenchProduct;
use App\Models\Gallery;
use App\Models\Image;
use App\Models\PotProduct;
use App\Models\Product;
use App\Models\Texture;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class MainController extends Controller
{
    function index() {
        return view('elitvid.site.index');
    }

    function about() {
        return view('elitvid.site.about');
    }

    function show_pot_product($id){
        $products = PotProduct::query()->with('pot_images')->where('id', $id)->get();
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

        return view('elitvid.site.pots.pot_product_page', compact('products', 'i', 'j', 'rows', 'count'));
    }

    function show_bench_product($id){
//        dd($product->where('id', $id)->collect());
        $products = benchProduct::query()->with('bench_images')->where('id', $id)->get();
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

        return view('elitvid.site.benches.bench_product_page', compact('products', 'i', 'j', 'rows', 'count'));
    }

    function benches() {

        return view('elitvid.site.benches');
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
        $lines_benches = $benches->where('collection', 'Line');

        return view('elitvid.site.benches.lines_benches', compact('lines_benches'));
    }

    function directions() {
        return view('elitvid.site.directions');
    }

    function decorations()
    {
        return view('elitvid.site.decorations');
    }

    function pots() {

//        $textures = Texture::query()->whereIn('active', [1])->get();
//        $natural_stone = $textures->where('type', 'natural_stone');
//        $moon_stone = $textures->where('type', 'moon_stone');
//        $mirror_stone = $textures->where('type', 'polished_stone');

//        $pots_gallery = Gallery::query()->where('type', 'pots')->with(['images'])->get();

        return view('elitvid.site.pots');
    }

    function rectangular_pots() {
//        $pots = Product::query()->whereIn('active', [1])->whereIn('item', ['pot'])->with(['images'])->get();
//        $rectangular_pots = $pots->where('type', 'Rectangular');
//        return view('elitvid.site.pots.rectangular_pots', compact('rectangular_pots'));
    }

    function square_pots() {
//        $pots = Product::query()->whereIn('active', [1])->whereIn('item', ['pot'])->with(['images'])->get();
//        $square_pots = $pots->where('type', 'Square');
//        return view('elitvid.site.pots.square_pots', compact('square_pots'));
    }

    function round_pots() {
//        $pots = PotProduct::query()->whereIn('active', [1])->with(['pot_images'])->get();
//        $round_pots = $pots->where('type', 'Round');
        $pots = PotProduct::query()->whereIn('active', [1])->with(['pot_images'])->get();
        $round_pots = $pots->where('collection', 'Round');
//        dd($pots = Product::query()->get());
        return view('elitvid.site.pots.round_pots', compact('round_pots'));
    }
}
