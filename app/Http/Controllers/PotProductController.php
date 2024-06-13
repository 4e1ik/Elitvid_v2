<?php

namespace App\Http\Controllers;

use App\Http\Requests\PotProductRequest;
use App\Models\Image;
use App\Models\PotImage;
use App\Models\PotProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use function Laravel\Prompts\warning;

class PotProductController extends Controller
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
    public function store(PotProductRequest $PotProductRequest)
    {
        $data = $PotProductRequest->all();

        for ($i = 2;  $i<=5; $i++){
            $data['size'] = $data['size'].'|'.$data['size'.$i];
            unset($data['size'.$i]);
            $data['weight'] = $data['weight'].'|'.$data['weight'.$i];
            unset($data['weight'.$i]);
            $data['price'] = $data['price'].'|'.$data['price'.$i];
            unset($data['price'.$i]);
        }

        $potProduct = PotProduct::create($data);

        $data['pot_product_id'] = $potProduct->id;

        if ($PotProductRequest->hasFile('image')) {
            foreach ($PotProductRequest->file('image') as $file) {
                $path = Storage::putFileAs('images', $file, save_image($file)); // Даем путь к этому файлу
                $data['image'] = $path;
                PotImage::create($data);

                ImageManager::gd()->read($file)->scaleDown(360,  275)->save(storage_path('app/public/images/'.'test'.save_image($file)));
            }
        }

//        $dataItem = $PotProduct->attributesToArray()['item'];
//        if ($dataItem == 'pot') {
//            $route = 'admin_pots';
//        } else if ($dataItem == 'bench') {
//            $route = 'admin_benches';
//        }

        return redirect(route('admin_pots'));
    }

    /**
     * Display the specified resource.
     */
    public function show(PotProduct $PotProduct)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PotProduct $PotProduct)
    {
        $req = \Illuminate\Support\Facades\Request::server('HTTP_REFERER');
        $route_name = explode("/",$req)[4];

        $images = Image::where('pot_product_id', $PotProduct->id)->get();

        return view('includes.elitvid.admin.update_PotProduct', compact( 'PotProduct', 'images', 'route_name'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PotProductRequest $PotProductRequest, PotProduct $potProduct)
    {
        $data = $PotProductRequest->all();

        $potProduct->fill($data)->save();

        $data['pot_product_id'] = $potProduct->id;

//        save_image($PotProductRequest);

        if ($PotProductRequest->hasFile('image')) {
            foreach ($PotProductRequest->file('image') as $file) {
                $path = Storage::putFileAs('images', $file, save_image($file)); // Даем путь к этому файлу
                $data['image'] = $path;
                Image::create($data);
            }
        }

//        $dataItem = $PotProduct->attributesToArray()['item'];
//        if ($dataItem == 'pot') {
//            $route = 'admin_pots';
//        } else if ($dataItem == 'bench') {
//            $route = 'admin_benches';
//        }

        return redirect(route('admin_pots'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PotProduct $potProduct)
    {
//        $dataItem = $PotProduct->attributesToArray()['item'];

//        if ($dataItem =='pot') {
//            $route = 'admin_pots';
//        } else if ($dataItem == 'bench') {
//            $route = 'admin_benches';
//        }

//        dd($potProduct->attributesToArray()['id']);

        $images = $potProduct->pot_images()->where('pot_product_id', $potProduct->attributesToArray()['id'])->get();
        foreach ($images as $image) {
            Storage::delete($image->image);
        }

//        dd($potProduct);

        $potProduct->delete();
        return redirect(route('admin_pots'));
    }
}
