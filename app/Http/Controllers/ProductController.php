<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use function Laravel\Prompts\warning;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $productRequest)
    {
        $data = $productRequest->all();

        $product = Product::create($data);

        $data['product_id'] = $product->id;

        save_image($productRequest);

        $dataItem = $product->attributesToArray()['item'];
        if ($dataItem == 'pot') {
            $route = 'admin_pots';
        } else if ($dataItem == 'bench') {
            $route = 'admin_benches';
        }

        return redirect(route($route));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $req = \Illuminate\Support\Facades\Request::server('HTTP_REFERER');
        $route_name = explode("/",$req)[4];

        $images = Image::where('product_id', $product->id)->get();

        return view('includes.elitvid.admin.update_product', compact( 'product', 'images', 'route_name'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $productRequest, Product $product)
    {
        $data = $productRequest->all();

        $product->fill($data)->save();

        $data['product_id'] = $product->id;

        save_image($productRequest);

//        if ($productRequest->hasFile('image')) {
//            foreach ($productRequest->file('image') as $file) {
//                $name = $file->getClientOriginalName();
//                $path = Storage::putFileAs('images', $file, $name); // Даем путь к этому файлу
//                $data['image'] = $path;
//                Image::create($data);
//            }
//        }

        $dataItem = $product->attributesToArray()['item'];
        if ($dataItem == 'pot') {
            $route = 'admin_pots';
        } else if ($dataItem == 'bench') {
            $route = 'admin_benches';
        }

        return redirect(route($route));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $dataItem = $product->attributesToArray()['item'];

        if ($dataItem =='pot') {
            $route = 'admin_pots';
        } else if ($dataItem == 'bench') {
            $route = 'admin_benches';
        }

        $images = $product->images()->where('product_id', $product->id)->get();
        foreach ($images as $image) {
            Storage::delete($image->image);
        }

        $product->delete();
        return redirect(route($route));
    }
}
