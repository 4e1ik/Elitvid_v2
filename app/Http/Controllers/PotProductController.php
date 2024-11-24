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

        $data['size'] = [];
        $data['weight'] = [];
        $data['price'] = [];
        for ($i = 1;  $i<=5; $i++){
            $data['size'][$i] = $data['size'.$i];
            $data['weight'][$i] = $data['weight'.$i];
            $data['price'][$i] = $data['price'.$i];
        }
        $data['size'] = implode('|', $data['size']);
        $data['weight'] = implode('|', $data['weight']);
        $data['price'] = implode('|', $data['price']);

        $potProduct = PotProduct::create($data);

        $data['pot_product_id'] = $potProduct->id;

        if ($PotProductRequest->hasFile('image')) {
            foreach ($PotProductRequest->file('image') as $file) {
                $name= save_image($file, PotImage::query());
                $path = Storage::putFileAs('public/images', $file, $name); // Даем путь к этому файлу
                $data['image'] = $path;
                PotImage::create($data);

                ImageManager::gd()->read($file)->scaleDown(480,  400)->save(storage_path('app/public/images/'.$name));

            }
        }

        $collection = $data['collection'];

        $potsRoutes = [
            'Square' => route('admin_square_pots'),
            'Round' => route('admin_round_pots'),
            'Rectangular' => route('admin_rectangular_pots'),
        ];

        return redirect($potsRoutes[$collection]);
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
    public function edit(PotProduct $potProduct)
    {
        $potImages = PotImage::query()->where('pot_product_id', $potProduct->id)->get();


        $sizes = explode('|', $potProduct->getAttribute('size'));
        $weights = explode('|', $potProduct->getAttribute('weight'));
        $prices = explode('|', $potProduct->getAttribute('price'));

        return view('includes.elitvid.admin.update_pot_product', compact( 'potProduct', 'potImages', 'sizes', 'weights', 'prices'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PotProductRequest $PotProductRequest, PotProduct $potProduct)
    {
        $data = $PotProductRequest->all();

        $data['size'] = [];
        $data['weight'] = [];
        $data['price'] = [];
        for ($i = 1;  $i<=5; $i++){
            $data['size'][$i] = $data['size'.$i];
            $data['weight'][$i] = $data['weight'.$i];
            $data['price'][$i] = $data['price'.$i];
        }
        $data['size'] = implode('|', $data['size']);
        $data['weight'] = implode('|', $data['weight']);
        $data['price'] = implode('|', $data['price']);

        $potProduct->fill($data)->save();

        $data['pot_product_id'] = $potProduct->id;

        if ($PotProductRequest->hasFile('image')) {
            foreach ($PotProductRequest->file('image') as $file) {
                $name= save_image($file, PotImage::query());
                $path = Storage::putFileAs('public/images', $file, $name); // Даем путь к этому файлу
                $data['image'] = $path;
                PotImage::create($data);

                ImageManager::gd()->read($file)->scaleDown(480,  400)->save(storage_path('app/public/images/'.$name));
            }
        }

        $collection = $data['collection'];

        $potsRoutes = [
            'Square' => route('admin_square_pots'),
            'Round' => route('admin_round_pots'),
            'Rectangular' => route('admin_rectangular_pots'),
        ];

        return redirect($potsRoutes[$collection]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PotProduct $potProduct)
    {
        $images = $potProduct->pot_images()->where('pot_product_id', $potProduct->attributesToArray()['id'])->get();
        foreach ($images as $image) {
            Storage::delete($image->image);
        }

        $potProduct->delete();
        return back();
    }
}
