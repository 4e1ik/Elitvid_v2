<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use App\Services\Admin\BlogService;
use App\Services\ImageService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function __construct(
        public ImageService $imageService,
        public BlogService  $blogService,
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blog_posts = Blog::all();
        return view('elitvid.admin.blog.blog_posts', compact('blog_posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('elitvid.admin.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogRequest $request)
    {
        $data = $request->all();

        $this->blogService->create(data: $data);

        return redirect(route('admin_blog'))->with('success', 'Пост успешно создан!');
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
        return view('elitvid.admin.blog.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $data = $request->all();

        $this->blogService->update(data: $data, blog: $blog);

        return redirect(route('admin_blog'))->with('success', 'Пост успешно обновлен!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $this->blogService->delete(blog: $blog);
        return back();
    }
}
