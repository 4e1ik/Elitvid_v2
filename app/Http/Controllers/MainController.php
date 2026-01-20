<?php

namespace App\Http\Controllers;

use App\Models\BenchProduct;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\MetaTag;
use App\Models\PotProduct;
use App\Models\StaticImages;
use App\Models\StaticPage;
use Illuminate\Support\Facades\Response;

class MainController extends Controller
{
    function index() {
        $static_pages = StaticPage::all();
        $main_page_images = Gallery::query()
            ->where('type', 'main_page')
            ->with(['gallery_images'])
            ->latest()
            ->get();
        $metaTags = MetaTag::where('page', 'main')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Главная страница';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание главной страницы';
        $categories = Category::where('page', 'main')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        $static_images = StaticImages::where('page', 'index')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
            if (str_ends_with($static_image->image, '.webp')) {
                $oldPath = str_replace('.webp', '.png', $static_image->image);
                $static_images_arr[$oldPath] = $static_image->description_image;
            }
        }
        return view('elitvid.site.index', compact( 'main_page_images', 'metaTitle', 'metaDescription', 'category', 'static_images_arr', 'static_pages'));
    }

    function test()
    {
        return view('elitvid.site.test');
    }

    function sitemap()
    {
        $filePath = public_path('sitemap.xml');
        if (!file_exists($filePath)) {
            abort(404, 'Sitemap not found.');
        }
        return Response::file($filePath, [
            'Content-Type' => 'application/xml',
        ]);
    }

    function about() {
        return view('elitvid.site.about');
    }

    function directions() {
        $metaTags = MetaTag::where('page', 'directions')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Наши направления';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание направлений';

        $static_pages = StaticPage::all();

        $categories = Category::where('page', 'directions')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        $static_images = StaticImages::where('page', 'directions')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
            if (str_ends_with($static_image->image, '.webp')) {
                $oldPath = str_replace('.webp', '.png', $static_image->image);
                $static_images_arr[$oldPath] = $static_image->description_image;
            }
        }
        return view('elitvid.site.directions', compact('metaTitle', 'metaDescription', 'category', 'static_images_arr', 'static_pages'));
    }

    function decorations()
    {
        $decorative_elements_images = Gallery::query()
            ->where('type', 'decorative_elements')
            ->with(['gallery_images'])
            ->latest()
            ->get();
        $metaTags = MetaTag::where('page', 'decorations')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Декоративные элементы';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание декоративных элементов';
        $categories = Category::where('page', 'decorations')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        $static_images = StaticImages::where('page', 'decorations')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
            if (str_ends_with($static_image->image, '.webp')) {
                $oldPath = str_replace('.webp', '.png', $static_image->image);
                $static_images_arr[$oldPath] = $static_image->description_image;
            }
        }
        return view('elitvid.site.decorations', compact('decorative_elements_images', 'metaTitle', 'metaDescription', 'category', 'static_images_arr'));
    }

    function blog_posts()
    {
        $blogs = Blog::whereIn('active', [1])->latest()->get();
        $metaTags = MetaTag::where('page', 'blog')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Блог';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание блога';
        $categories = Category::where('page', 'blog')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        return view('elitvid.site.blog.blog', compact('blogs', 'metaTitle', 'metaDescription', 'category'));
    }

    function show_blog_post($id)
    {
        $blog = Blog::where('id', $id)->first();
        if (!$blog) {
            abort(404);
        }
        $nextPost = Blog::where('created_at', '<', $blog->created_at)->latest()->first();
        $prevPost = Blog::where('created_at', '>', $blog->created_at)->oldest()->first();
        $metaTitle = $blog->meta_title ?? 'Блог';
        $metaDescription = $blog->meta_description ?? 'Описание поста блога';

        return view('elitvid.site.blog.blog_post', compact('blog', 'metaTitle', 'metaDescription', 'nextPost', 'prevPost'));
    }
}
