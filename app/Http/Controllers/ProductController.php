<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
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
    public function store(ProductRequest $ProductRequest)
    {
        $data = $ProductRequest->all();

        $Product = Product::create($data);

        $data['Product_id'] = $Product->id;

//        save_image($ProductRequest);

//        dd($data);

        if ($ProductRequest->hasFile('image')) {
            foreach ($ProductRequest->file('image') as $file) {
                $path = Storage::putFileAs('images', $file, save_image($file)); // Даем путь к этому файлу
                $data['image'] = $path;
                Image::create($data);

                ImageManager::gd()->read($file)->scaleDown(360,  275)->save(storage_path('app/public/images/'.'test'.save_image($file)));
            }
        }

        $dataItem = $Product->attributesToArray()['item'];
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
    public function show(Product $Product)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $Product)
    {
        $req = \Illuminate\Support\Facades\Request::server('HTTP_REFERER');
        $route_name = explode("/",$req)[4];

        $images = Image::where('Product_id', $Product->id)->get();

        return view('includes.elitvid.admin.update_Product', compact( 'Product', 'images', 'route_name'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $ProductRequest, Product $Product)
    {
        $data = $ProductRequest->all();

        $Product->fill($data)->save();

        $data['Product_id'] = $Product->id;

//        save_image($ProductRequest);

        if ($ProductRequest->hasFile('image')) {
            foreach ($ProductRequest->file('image') as $file) {
                $path = Storage::putFileAs('images', $file, save_image($file)); // Даем путь к этому файлу
                $data['image'] = $path;
                Image::create($data);
            }
        }

        $dataItem = $Product->attributesToArray()['item'];
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
    public function destroy(Product $Product)
    {
        $dataItem = $Product->attributesToArray()['item'];

        if ($dataItem =='pot') {
            $route = 'admin_pots';
        } else if ($dataItem == 'bench') {
            $route = 'admin_benches';
        }

        $images = $Product->images()->where('Product_id', $Product->id)->get();
        foreach ($images as $image) {
            Storage::delete($image->image);
        }

        $Product->delete();
        return redirect(route($route));
    }
}
