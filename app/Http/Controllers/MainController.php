<?php

namespace App\Http\Controllers;

use App\Helpers\WebResponse;
use App\Models\Blog;
use App\Models\StaticPage;
use App\Repositories\PageContentRepository;
use App\Repositories\StaticImagesRepository;
use App\Repositories\StaticPageRepository;
use Illuminate\Support\Facades\Response;

class MainController extends Controller
{
    public function __construct(
        public StaticPageRepository $staticPageRepository,
        public PageContentRepository $pageContentRepository,
        public StaticImagesRepository $staticImagesRepository,
    ){}

    function index() {
        try {
            $static_pages = $this->staticPageRepository->getAllStaticPages();
            $pageContent =  $this->pageContentRepository->getPageContent(page: 'main');
            $static_images_arr = $this->staticImagesRepository->getStaticImagesForPage(page: 'index');
            return WebResponse::success(view('elitvid.site.index', compact( 'pageContent', 'static_images_arr', 'static_pages')));
        } catch (\Exception $e) {
            return WebResponse::error($e);
        }
    }

    function test()
    {
        try {
            return WebResponse::success(view('elitvid.site.test'));
        } catch (\Exception $e) {
            return WebResponse::error($e);
        }
    }

    function sitemap()
    {
        try {
            $filePath = public_path('sitemap.xml');
            if (!file_exists($filePath)) {
                abort(404, 'Sitemap not found.');
            }
            return WebResponse::success(Response::file($filePath, [
                'Content-Type' => 'application/xml',
            ]));
        } catch (\Exception $e) {
            return WebResponse::error($e);
        }
    }

    function directions() {
        try {
            $static_pages = $this->staticPageRepository->getAllStaticPages();
            $pageContent =  $this->pageContentRepository->getPageContent(page: 'directions');
            $static_images_arr = $this->staticImagesRepository->getStaticImagesForPage(page: 'directions');
            return WebResponse::success(view('elitvid.site.directions', compact( 'pageContent', 'static_images_arr', 'static_pages')));
        } catch (\Exception $e) {
            return WebResponse::error($e);
        }
    }

    function decorations()
    {
        try {
            $static_pages = $this->staticPageRepository->getAllStaticPages();
            $pageContent =  $this->pageContentRepository->getPageContent(page: 'decorations');
            $static_images_arr = $this->staticImagesRepository->getStaticImagesForPage(page: 'decorations');
            return WebResponse::success(view('elitvid.site.decorations', compact('pageContent', 'static_images_arr', 'static_pages')));
        } catch (\Exception $e) {
            return WebResponse::error($e);
        }
    }

    function blog_posts()
    {
        try {
            $static_pages = $this->staticPageRepository->getAllStaticPages();
            $blogs = Blog::whereIn('active', [1])->latest()->get();
            $pageContent = $this->pageContentRepository->getPageContent(page: 'blog');
            $category = $pageContent?->category_description ?? null;
            return WebResponse::success(view('elitvid.site.blog.blog', compact('blogs', 'category', 'static_pages', 'pageContent')));
        } catch (\Exception $e) {
            return WebResponse::error($e);
        }
    }

    function show_blog_post(string $slug)
    {
        try {
            $static_pages = $this->staticPageRepository->getAllStaticPages();
            $blog = Blog::where('slug', $slug)->first();
            if (!$blog) {
                abort(404);
            }
            $nextPost = Blog::where('created_at', '<', $blog->created_at)->latest()->first();
            $prevPost = Blog::where('created_at', '>', $blog->created_at)->oldest()->first();
            $metaTitle = $blog->meta_title ?? 'Блог';
            $metaDescription = $blog->meta_description ?? 'Описание поста блога';

            return WebResponse::success(view('elitvid.site.blog.blog_post', compact('blog', 'metaTitle', 'metaDescription', 'nextPost', 'prevPost', 'static_pages')));
        } catch (\Exception $e) {
            return WebResponse::error($e);
        }
    }
}
