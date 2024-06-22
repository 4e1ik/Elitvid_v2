<?php
//
//namespace App\Http\Controllers;
//
//use App\Http\Requests\GalleryRequest;
//use App\Models\Gallery;
//use App\Models\Image;
//use App\Models\Texture;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Storage;
//
//class GalleryController extends Controller
//{
//    /**
//     * Display a listing of the resource.
//     */
//    public function index()
//    {
//        //
//    }
//
//    /**
//     * Show the form for creating a new resource.
//     */
//    public function create()
//    {
//        //
//    }
//
//    /**
//     * Store a newly created resource in storage.
//     */
//    public function store(GalleryRequest $galleryRequest)
//    {
//        $data = $galleryRequest->all();
//
//        $gallery = Gallery::create($data);
//
//        $data['gallery_id'] = $gallery->id;
//
////        save_image($galleryRequest);
//
//        if ($galleryRequest->hasFile('image')) {
//            foreach ($galleryRequest->file('image') as $file) {
//                $name = $file->getClientOriginalName();
//                $path = Storage::putFileAs('images', $file, save_image($file)); // Даем путь к этому файлу
//                $data['image'] = $path;
//                Image::create($data);
//            }
//        }
//
//        return redirect(route('admin_gallery'));
//    }
//
//    /**
//     * Display the specified resource.
//     */
//    public function show(string $id)
//    {
//        //
//    }
//
//    /**
//     * Show the form for editing the specified resource.
//     */
//    public function edit(string $id)
//    {
//        //
//    }
//
//    /**
//     * Update the specified resource in storage.
//     */
//    public function update(Request $request, string $id)
//    {
//        //
//    }
//
//    /**
//     * Remove the specified resource from storage.
//     */
//    public function destroy(Image $image)
//    {
//        //
//    }
//}
