<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Image;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    function index() {
        return view('elitvid.admin.admin');
    }

    function catalog() {
        return view('elitvid.admin.catalog');
    }

    function benches(Post $post) {
        $benches_stones = Post::where('item', 2)->where('type', 9)->get();
        $benches_radius = Post::where('item', 2)->where('type', 10)->get();
        $benches_solo = Post::where('item', 2)->where('type', 11)->get();
        $benches_outdoor = Post::where('item', 2)->where('type', 12)->get();
        return view('elitvid.admin.benches.benches',
            compact('benches_stones','benches_radius','benches_solo', 'benches_outdoor',  'post')
        );
    }

    function pots(Post $post) {

        $round_pots = Post::where('item', 1)->where('type', 2)->get();
        $rectangular_pots = Post::where('item', 1)->where('type', 3)->get();
        $square_pots = Post::where('item', 1)->where('type', 1)->get();

        return view('elitvid.admin.pots.pots',
        compact('round_pots', 'rectangular_pots', 'square_pots', 'post')
        );
    }

    function textures(Post $post) {
        $natural_stones = Post::where('item', 4)->where('type', 4)->get();
        $moon_stones = Post::where('item', 4)->where('type', 5)->get();
        $polished_stones = Post::where('item', 4)->where('type', 6)->get();
        $wood_species = Post::where('item', 4)->where('type', 7)->get();
        $wood_impregnation = Post::where('item', 4)->where('type', 8)->get();
        return view(
            'elitvid.admin.textures', compact(
            'natural_stones', 'moon_stones', 'polished_stones', 'wood_species', 'wood_impregnation', 'post'
            )
        );
    }

    function gallery(Post $post) {
        $pots_images = Image::where('type_img', 13)->get();
        $benches_images = Image::where('type_img', 14)->get();
        return view(
            'elitvid.admin.gallery', compact(
                'pots_images','benches_images','post'
            )
        );
    }

    public function create($route){

        $route_name = $route;

        return view('includes.elitvid.admin.create_product', compact('route_name'));
    }

}
