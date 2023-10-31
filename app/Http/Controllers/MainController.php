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
        $stones_benches = Product::where('active', 1)->where('item', 'bench')->where('type', 'Stones')->get();
        $radius_benches = Product::where('active', 1)->where('item', 'bench')->where('type', 'Radius')->get();
        $solo_benches = Product::where('active', 1)->where('item', 'bench')->where('type', 'Solo')->get();
        $outdoor_benches = Product::where('active', 1)->where('item', 'bench')->where('type', 'Outdoor')->get();
        $wood_species = Texture::where('active', 1)->where('type', 'wood_species')->get();
        $wood_impregnation = Texture::where('active', 1)->where('type', 'wood_impregnation')->get();
        $benches_gallery = Gallery::where('type', 'benches')->get();
        return view(
            'elitvid.site.benches', compact(
                'wood_impregnation',
                'wood_species',
                'benches_gallery',
                'stones_benches',
                'radius_benches',
                'solo_benches',
                'outdoor_benches'
            )
        );
    }

    function catalog() {
        return view('elitvid.site.catalog');
    }

    function pots() {
        $natural_stone = Texture::where('active', 1)->where('type', 'natural_stone')->get();
        $moon_stone = Texture::where('active', 1)->where('type', 'moon_stone')->get();
        $mirror_stone = Texture::where('active', 1)->where('type', 'polished_stone')->get();
        $pots_gallery = Gallery::where('type', 'pots')->get();

        return view('elitvid.site.pots', compact('natural_stone', 'moon_stone', 'mirror_stone', 'pots_gallery'));
    }

    function rectangular_pots() {
        $rectangular_pots = Product::where('active', 1)->where('type', 'Rectangular')->get();
        return view('elitvid.site.pots.rectangular_pots', compact('rectangular_pots'));
    }

    function square_pots() {
        $square_pots = Product::where('active', 1)->where('type', 'Square')->get();
        return view('elitvid.site.pots.square_pots', compact('square_pots'));
    }

    function round_pots() {
        $round_pots = Product::where('active', 1)->where('type', 'Round')->get();
        return view('elitvid.site.pots.round_pots', compact('round_pots'));
    }
}
