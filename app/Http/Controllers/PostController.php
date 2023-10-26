<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Image;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Storage;
use function Sodium\compare;

class PostController extends Controller
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
//        $req = \Illuminate\Support\Facades\Request::server('HTTP_REFERER');
//        $route_name = explode("/",$req)[4];
//
////        $url = route('admin_pots');
//
////        $route_name = $route;
//
////        dd($route_name);
//
//        return view('includes.elitvid.admin.create_product', compact('route_name'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $data = $request->all();

        $post = Post::create($data);

        $data['post_id'] = $post->id;

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $name = $file->getClientOriginalName();
                $path = Storage::putFileAs('images', $file, $name); // Даем путь к этому файлу
                $data['image'] = $path;
                Image::create($data);
            }
        }

        $dataItem = $post->attributesToArray()['item'];
        if ($dataItem == 1) {
            $route = 'admin_pots';
        } else if ($dataItem == 2) {
            $route = 'admin_benches';
        } else if ($dataItem == 3) {
            $route = '';
        } else if ($dataItem == 4) {
            $route = 'admin_textures';
        } else if ($dataItem == 5) {
            $route = 'admin_gallery';
        }

//        dd($dataItem);

        return redirect(route($route));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $req = \Illuminate\Support\Facades\Request::server('HTTP_REFERER');
        $route_name = explode("/",$req)[4];

        $post = Post::where('id',$id)->get();
        $images = Image::where('post_id', $id)->get();
            foreach ($post as $item)
            {
                if ($item->item == 1){
                    $route = 'pots';
                } else if ($item->item == 2){
                    $route = 'benches';
                } else if ($item->item == 3){
                    $route = 'catalog';
                } else if ($item->item == 4){
                    $route = 'textures';
                } else if ($item->item == 5){
                    $route = 'gallery';
                }
            }

        return view('includes.elitvid.admin.update_product', compact('route_name', 'post', 'images', 'route'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        $data = $request->all();

        $post->fill($data)->save();

        $data['post_id'] = $post->id;

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $name = $file->getClientOriginalName();
                $path = Storage::putFileAs('images', $file, $name); // Даем путь к этому файлу
                $data['image'] = $path;
                Image::create($data);
            }
        }

        $dataItem = $post->attributesToArray()['item'];
        if ($dataItem == 1) {
            $route = 'admin_pots';
        } else if ($dataItem == 2) {
            $route = 'admin_benches';
        } else if ($dataItem == 3) {
            $route = '';
        } else if ($dataItem == 4) {
            $route = 'admin_textures';
        } else if ($dataItem == 5) {
            $route = 'admin_gallery';
        }

        return redirect(route($route));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {

        $dataItem = $post->attributesToArray()['item'];
        if ($dataItem == 1) {
            $route = 'admin_pots';
        } else if ($dataItem == 2) {
            $route = 'admin_benches';
        } else if ($dataItem == 3) {
            $route = '';
        } else if ($dataItem == 4) {
            $route = 'admin_textures';
        } else if ($dataItem == 5) {
            $route = 'admin_gallery';
        }
        $post->delete();
        return redirect(route($route));
    }
}
