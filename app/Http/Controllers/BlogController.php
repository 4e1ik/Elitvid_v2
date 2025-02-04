<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
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
        return view('includes.elitvid.admin.create_blog_post');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('main_image')) {
            $image = $request->file('main_image');
            $extension = $image->getClientOriginalExtension();
            $name = hash('md5', $image->getClientOriginalName());
            $path = Storage::putFileAs('public/images', $image, $name.'.'.$extension); // Даем путь к этому файлу
            $data['main_image'] = $path;
        }
        Blog::create($data);

        return redirect(route('admin_blog'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        return view('includes.elitvid.admin.update_blog_post', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $data = $request->all();

        $blog->fill($data)->save();

        return redirect(route('admin_blog'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        Storage::delete($blog->main_image);
        $blog->delete();
        return back();
    }
}
