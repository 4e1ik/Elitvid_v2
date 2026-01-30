<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePageContentRequest;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\Image;
use App\Models\PageContent;
use App\Repositories\Admin\PageContentRepository;
use App\Services\Admin\PageContentService;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageContentController extends Controller
{
    public function __construct(
        public ImageService          $imageService,
        public PageContentRepository $pageContentRepository,
        public PageContentService    $pageContentService
    ){}

    /**
     * Список всех страниц с контентом
     */
    public function index()
    {
        $pageContents = $this->pageContentRepository->getAllPages();
        $pageContents->map(function ($pageContent) {
            return $pageContent->name = config('pages', [])[$pageContent->page] ?? $pageContent->page;
        });
        return view('elitvid.admin.page_contents.index', compact('pageContents'));
    }

    /**
     * Страница редактирования контента
     */
    public function edit(PageContent $pageContent)
    {
        $pageContent->pageName = config('pages', [])[$pageContent->page] ?? $pageContent->page;
        return view('elitvid.admin.page_contents.edit', compact('pageContent'));
    }

    /**
     * Обновление контента страницы
     */
    public function update(UpdatePageContentRequest $request, PageContent $pageContent)
    {
        $data = $request->all();

        $this->pageContentService->update(data: $data, pageContent: $pageContent);

        return redirect()->route('admin_page_contents.index')
            ->with('success', 'Контент страницы успешно обновлен');
    }
}
