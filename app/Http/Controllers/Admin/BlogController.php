<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function __construct(
        public ImageService $imageService,
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
        return DB::transaction(function () use ($request) {
            $data = $request->all();
            unset($data['main_image']); // Убираем из данных, так как будем сохранять через ImageService

            $blog = Blog::create($data);

            // Сохраняем главное изображение через ImageService
            if ($request->hasFile('main_image')) {
                $this->imageService->save(
                    images: [$request->file('main_image')],
                    model: $blog,
                    imageData: [[
                        'main_image' => true,
                        'menu_image' => false,
                    ]]
                );
            }

            return redirect(route('admin_blog'))->with('success', 'Пост успешно создан!');
        });
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
        return DB::transaction(function () use ($request, $blog) {
            $data = $request->all();
            unset($data['main_image']); // Убираем из данных, так как будем сохранять через ImageService

            $blog->update($data);

            // Обработка новой главной картинки
            if ($request->hasFile('main_image')) {
                // Удаляем старое главное изображение
                $oldMainImage = $blog->images()->where('main_image', true)->first();
                if ($oldMainImage) {
                    $this->imageService->delete($oldMainImage);
                }

                // Сохраняем новое главное изображение
                $this->imageService->save(
                    images: [$request->file('main_image')],
                    model: $blog,
                    imageData: [[
                        'main_image' => true,
                        'menu_image' => false,
                    ]]
                );
            }

            return redirect(route('admin_blog'))->with('success', 'Пост успешно обновлен!');
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        return DB::transaction(function () use ($blog) {
            // Удаляем все изображения блога
            foreach ($blog->images as $image) {
                $this->imageService->delete($image);
            }

            // Удаляем старое изображение, если оно хранится в поле main_image (для обратной совместимости)
            if ($blog->main_image) {
                Storage::delete($blog->main_image);
            }

            $blog->delete();
            return back();
        });
    }
}
