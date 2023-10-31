<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Gallery;
use App\Models\Image;
use App\Models\Post;
use App\Models\Product;
use App\Models\Texture;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    function index() {
        return view('elitvid.admin.admin');
    }

    function catalog() {
        return view('elitvid.admin.catalog');
    }

    function benches(Product $product) {

        $benches_stones = Product::where('item', 'bench')->where('type', 'Stones')->get();
        $benches_radius = Product::where('item', 'bench')->where('type', 'Radius')->get();
        $benches_solo = Product::where('item', 'bench')->where('type', 'Solo')->get();
        $benches_outdoor = Product::where('item', 'bench')->where('type', 'Outdoor')->get();
        return view('elitvid.admin.benches.benches',
            compact('benches_stones','benches_radius','benches_solo', 'benches_outdoor',  'product')
        );
    }

    function pots(Product $product) {

        $round_pots = Product::where('item', 'pot')->where('type', 'Round')->get();
        $rectangular_pots = Product::where('item', 'pot')->where('type', 'Rectangular')->get();
        $square_pots = Product::where('item', 'pot')->where('type', 'Square')->get();

        return view('elitvid.admin.pots.pots',
        compact('round_pots', 'rectangular_pots', 'square_pots', 'product')
        );
    }

    function textures(Texture $texture) {
        $natural_stones = Texture::where('type', 'natural_stone')->get();
        $moon_stones = Texture::where('type', 'moon_stone')->get();
        $polished_stones = Texture::where('type', 'polished_stone')->get();
        $wood_species = Texture::where('type', 'wood_species')->get();
        $wood_impregnation = Texture::where('type', 'wood_impregnation')->get();
        return view(
            'elitvid.admin.textures', compact(
            'natural_stones', 'moon_stones', 'polished_stones', 'wood_species', 'wood_impregnation', 'texture'
            )
        );
    }

    function gallery(Gallery $gallery) {
        $pots_images = Gallery::where('type', 'pots')->get();
        $benches_images = Gallery::where('type', 'benches')->get();
        return view(
            'elitvid.admin.gallery', compact(
                'pots_images','benches_images','gallery'
            )
        );
    }

    public function create($route){

        $route_name = $route;

        if ($route_name == 'textures'){
            return view('includes.elitvid.admin.create_texture', compact('route_name'));
        } else if($route_name == 'gallery'){
            return view('includes.elitvid.admin.create_gallery', compact('route_name'));
        }

        return view('includes.elitvid.admin.create_product', compact('route_name'));

    }

}
