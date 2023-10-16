<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Post;
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
        $stones_benches = Post::where('active', 1)->where('item', 2)->where('type', 9)->get();
        $radius_benches = Post::where('active', 1)->where('item', 2)->where('type', 10)->get();
        $solo_benches = Post::where('active', 1)->where('item', 2)->where('type', 11)->get();
        $outdoor_benches = Post::where('active', 1)->where('item', 2)->where('type', 12)->get();
        $wood_species = Post::where('active', 1)->where('item', 4)->where('type', 7)->get();
        $wood_impregnation = Post::where('active', 1)->where('item', 4)->where('type', 8)->get();
        $benches_gallery = Image::where('type_img', 14)->get();
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

        $natural_stone = Post::where('active', 1)->where('item', 4)->where('type', 4)->get();
        $moon_stone = Post::where('active', 1)->where('item', 4)->where('type', 5)->get();
        $mirror_stone = Post::where('active', 1)->where('item', 4)->where('type', 6)->get();
        $pots_gallery = Image::where('type_img', 13)->get();

        return view('elitvid.site.pots', compact('natural_stone', 'moon_stone', 'mirror_stone', 'pots_gallery'));
    }

    function rectangular_pots() {
        $rectangular_pots = Post::where('active', 1)->where('item', 1)->where('type', 3)->get();
        return view('elitvid.site.pots.rectangular_pots', compact('rectangular_pots'));
    }

    function square_pots() {
        $square_pots = Post::where('active', 1)->where('item', 1)->where('type', 1)->get();
        return view('elitvid.site.pots.square_pots', compact('square_pots'));
    }

    function round_pots() {
        $round_pots = Post::where('active', 1)->where('item', 1)->where('type', 2)->get();
        return view('elitvid.site.pots.round_pots', compact('round_pots'));
    }
}
