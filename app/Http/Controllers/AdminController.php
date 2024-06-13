<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Gallery;
use App\Models\Image;
use App\Models\Post;
use App\Models\PotProduct;
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

        $benches = Product::query()->whereIn('item', ['bench'])->get();
        $benches_stones = $benches->where('type', 'Stones');
        $benches_radius = $benches->where('type', 'Radius');
        $benches_solo = $benches->where('type', 'Solo');
        $benches_outdoor = $benches->where('type', 'Outdoor');
        return view('elitvid.admin.benches.benches',
            compact('benches_stones','benches_radius','benches_solo', 'benches_outdoor',  'product')
        );
    }

    function pots(PotProduct $PotProduct) {

//        $pots = PotProduct::query()->whereIn('item', ['pot'])->get();
//        $round_pots = PotProduct::where('collection', 'Round');
        $round_pots = PotProduct::query()->where('collection', 'Round')->get();
        $rectangular_pots = PotProduct::query()->where('collection', 'Rectangular')->get();
        $square_pots = PotProduct::query()->where('collection','Square')->get();
//        dd($square_pots);
//        dd($round_pots);
//        $rectangular_pots = PotProduct::where('collection', 'Rectangular');
//        $square_pots = PotProduct::where('collection', 'Square');


        return view('elitvid.admin.pots.pots', compact('round_pots', 'rectangular_pots', 'square_pots', 'PotProduct'));
//        return view('elitvid.admin.pots.pots');
    }

    function textures(Texture $texture) {

        $textures = Texture::query()->with(['images'])->get();
        $natural_stones = $textures->where('type', 'natural_stone');
        $moon_stones = $textures->where('type', 'moon_stone');
        $polished_stones = $textures->where('type', 'polished_stone');
        $wood_species = $textures->where('type', 'wood_species');
        $wood_impregnation = $textures->where('type', 'wood_impregnation');
        return view(
            'elitvid.admin.textures', compact(
            'natural_stones', 'moon_stones', 'polished_stones', 'wood_species', 'wood_impregnation', 'texture'
            )
        );
    }

    function gallery(Gallery $gallery) {
        $gallery = Gallery::query()->with(['images'])->get();
        $pots_images = $gallery->where('type', 'pots');
        $benches_images = $gallery->where('type', 'benches');

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
        } else if($route_name == 'pots'){
            return view('includes.elitvid.admin.create_pot_product', compact('route_name'));
        } else if($route_name == 'benches'){
            return view('includes.elitvid.admin.create_bench_product', compact('route_name'));
        }

//        return view('includes.elitvid.admin.create_product', compact('route_name'));

    }

}
