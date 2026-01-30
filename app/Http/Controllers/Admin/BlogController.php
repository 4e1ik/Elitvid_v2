<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\WebResponse;
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
        try {
            return WebResponse::success(view('elitvid.admin.blog.blog_posts', [
                'blog_posts' => Blog::all(),
            ]));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return WebResponse::success(view('elitvid.admin.blog.create'));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogRequest $request)
    {
        try {
            $data = $request->all();
            $this->blogService->create(data: $data);
            return WebResponse::success(redirect(route('admin_blog'))->with('success', 'Пост успешно создан!'));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
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
        try {
            return WebResponse::success(view('elitvid.admin.blog.edit', compact('blog')));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        try {
            $data = $request->all();
            $this->blogService->update(data: $data, blog: $blog);
            return WebResponse::success(redirect(route('admin_blog'))->with('success', 'Пост успешно обновлен!'));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        try {
            $this->blogService->delete(blog: $blog);
            return WebResponse::success(back());
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }
}
