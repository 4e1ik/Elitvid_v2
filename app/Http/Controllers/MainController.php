<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Image;
use App\Models\Post;
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

    function benches() {
        $benches = Product::query()->whereIn('active', [1])->whereIn('item', ['bench'])->with(['images'])->get();
        $stones_benches = $benches->where('type', 'Stones');
        $radius_benches = $benches->where('type', 'Radius');
        $solo_benches = $benches->where('type', 'Solo');
        $outdoor_benches = $benches->where('type', 'Outdoor');


        $textures = Texture::query()->whereIn('active', [1])->get();
        $wood_species = $textures->where('type', 'wood_species');
        $wood_impregnation = $textures->where('type', 'wood_impregnation');


        $benches_gallery = Gallery::query()->where('type', 'benches')->with(['images'])->get();


        return view(
            'elitvid.site.benches', compact(
                'wood_impregnation',
                'wood_species',
                'benches_gallery',
                'stones_benches',
                'radius_benches',
                'solo_benches',
                'outdoor_benches',
            )
        );
    }

    function catalog() {
        return view('elitvid.site.catalog');
    }

    function pots() {

        $textures = Texture::query()->whereIn('active', [1])->get();
        $natural_stone = $textures->where('type', 'natural_stone');
        $moon_stone = $textures->where('type', 'moon_stone');
        $mirror_stone = $textures->where('type', 'polished_stone');


        $pots_gallery = Gallery::query()->where('type', 'pots')->with(['images'])->get();

        return view('elitvid.site.pots', compact('natural_stone', 'moon_stone', 'mirror_stone', 'pots_gallery'));
    }

    function rectangular_pots() {
        $pots = Product::query()->whereIn('active', [1])->whereIn('item', ['pot'])->with(['images'])->get();
        $rectangular_pots = $pots->where('type', 'Rectangular');
        return view('elitvid.site.pots.rectangular_pots', compact('rectangular_pots'));
    }

    function square_pots() {
        $pots = Product::query()->whereIn('active', [1])->whereIn('item', ['pot'])->with(['images'])->get();
        $square_pots = $pots->where('type', 'Square');
        return view('elitvid.site.pots.square_pots', compact('square_pots'));
    }

    function round_pots() {
        $pots = Product::query()->whereIn('active', [1])->whereIn('item', ['pot'])->with(['images'])->get();
        $round_pots = $pots->where('type', 'Round');
        return view('elitvid.site.pots.round_pots', compact('round_pots'));
    }
}
