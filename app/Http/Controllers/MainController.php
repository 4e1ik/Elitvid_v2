<?php

namespace App\Http\Controllers;

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
        $static_pages = $this->staticPageRepository->getAllStaticPages();
        $pageContent =  $this->pageContentRepository->getPageContent(page: 'main');
        $static_images_arr = $this->staticImagesRepository->getStaticImagesForPage(page: 'index');
        return view('elitvid.site.index', compact( 'pageContent', 'static_images_arr', 'static_pages'));
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

    function directions() {
        $static_pages = $this->staticPageRepository->getAllStaticPages();
        $pageContent =  $this->pageContentRepository->getPageContent(page: 'directions');
        $static_images_arr = $this->staticImagesRepository->getStaticImagesForPage(page: 'directions');
        return view('elitvid.site.directions', compact( 'pageContent', 'static_images_arr', 'static_pages'));
    }

    function decorations()
    {
        $static_pages = $this->staticPageRepository->getAllStaticPages();
        $pageContent =  $this->pageContentRepository->getPageContent(page: 'directions');
        $static_images_arr = $this->staticImagesRepository->getStaticImagesForPage(page: 'index');
        return view('elitvid.site.decorations', compact('pageContent', 'static_images_arr', 'static_pages'));
    }

    function blog_posts()
    {
        $static_pages = $this->staticPageRepository->getAllStaticPages();
        $blogs = Blog::whereIn('active', [1])->latest()->get();
        $pageContent = $this->pageContentRepository->getPageContent(page: 'blog');
        $category = $pageContent?->category_description ?? null;
        return view('elitvid.site.blog.blog', compact('blogs', 'category', 'static_pages', 'pageContent'));
    }

    function show_blog_post($id)
    {
        $static_pages = StaticPage::all();
        $blog = Blog::where('id', $id)->first();
        if (!$blog) {
            abort(404);
        }
        $nextPost = Blog::where('created_at', '<', $blog->created_at)->latest()->first();
        $prevPost = Blog::where('created_at', '>', $blog->created_at)->oldest()->first();
        $metaTitle = $blog->meta_title ?? 'Блог';
        $metaDescription = $blog->meta_description ?? 'Описание поста блога';

        return view('elitvid.site.blog.blog_post', compact('blog', 'metaTitle', 'metaDescription', 'nextPost', 'prevPost', 'static_pages'));
    }
}
