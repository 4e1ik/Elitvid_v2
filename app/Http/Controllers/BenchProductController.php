<?php

namespace App\Http\Controllers;

use App\Http\Requests\BenchProductRequest;
use App\Models\BenchImage;
use App\Models\BenchProduct;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use function Laravel\Prompts\warning;

class BenchProductController extends Controller
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
    public function store(BenchProductRequest $benchProductRequest, BenchImage $benchImage)
    {
        $data = $benchProductRequest->all();

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

        $benchProduct = BenchProduct::create($data);

        $data['bench_product_id'] = $benchProduct->id;


        if ($benchProductRequest->hasFile('image')) {
            foreach ($benchProductRequest->file('image') as $file) {
                $name= save_image($file, BenchImage::query());
                $path = Storage::putFileAs('public/images', $file, $name); // Даем путь к этому файлу
                $data['image'] = $path;

                BenchImage::create($data);

                ImageManager::gd()->read($file)->scaleDown(480,  400)->save(storage_path('app/public/images/'.$name));
            }
        }

        $collection = $data['collection'];

        $benchRoutes = [
            'Verona' => route('admin_benches_verona'),
            'Stones' => route('admin_benches_stones'),
            'lines' => route('admin_benches_solo'),
            'Solo' => route('admin_benches_lines'),
            'Street_furniture' => route('admin_benches_street_furniture'),
        ];

        return redirect($benchRoutes[$collection]);
    }

    /**
     * Display the specified resource.
     */
    public function show(BenchProduct $benchProduct)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BenchProduct $benchProduct)
    {
        $benchImages = BenchImage::query()->where('bench_product_id', $benchProduct->id)->get();


        $sizes = explode('|', $benchProduct->getAttribute('size'));
        $weights = explode('|', $benchProduct->getAttribute('weight'));
        $prices = explode('|', $benchProduct->getAttribute('price'));

        return view('includes.elitvid.admin.update_bench_product', compact( 'benchImages', 'benchProduct', 'sizes', 'weights', 'prices'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BenchProductRequest $benchProductRequest, BenchProduct $benchProduct, BenchImage $benchImage)
    {
        $data = $benchProductRequest->all();

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

        $benchProduct->fill($data)->save();

        if ($benchProductRequest->hasFile('image')) {
            foreach ($benchProductRequest->file('image') as $file) {
                $name= save_image($file, BenchImage::query());
                $path = Storage::putFileAs('public/images', $file, $name); // Даем путь к этому файлу
                $data['image'] = $path;
                $data['bench_product_id'] = $benchProduct->id;
                BenchImage::create($data);

                ImageManager::gd()->read($file)->scaleDown(480,  400)->save(storage_path('app/public/images/'.$name));
            }
        }

        $collection = $data['collection'];

        $benchRoutes = [
            'Verona' => route('admin_benches_verona'),
            'Stones' => route('admin_benches_stones'),
            'lines' => route('admin_benches_solo'),
            'Solo' => route('admin_benches_lines'),
            'Street_furniture' => route('admin_benches_street_furniture'),
        ];

        return redirect($benchRoutes[$collection]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BenchProduct $benchProduct)
    {
        $images = $benchProduct->bench_images()->where('bench_product_id', $benchProduct->attributesToArray()['id'])->get();
        foreach ($images as $image) {
            Storage::delete($image->image);
        }

        $benchProduct->delete();
        return back();
    }
}
