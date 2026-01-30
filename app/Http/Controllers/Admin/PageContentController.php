<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\WebResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePageContentRequest;
use App\Models\PageContent;
use App\Repositories\Admin\PageContentRepository;
use App\Services\Admin\PageContentService;
use App\Services\ImageService;
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
        try {
            $pageContents = $this->pageContentRepository->getAllPages();
            $pageContents->map(function ($pageContent) {
                return $pageContent->name = config('pages', [])[$pageContent->page] ?? $pageContent->page;
            });
            return WebResponse::success(view('elitvid.admin.page_contents.index', compact('pageContents')));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }

    /**
     * Страница редактирования контента
     */
    public function edit(PageContent $pageContent)
    {
        try {
            $pageContent->pageName = config('pages', [])[$pageContent->page] ?? $pageContent->page;
            return WebResponse::success(view('elitvid.admin.page_contents.edit', compact('pageContent')));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }

    /**
     * Обновление контента страницы
     */
    public function update(UpdatePageContentRequest $request, PageContent $pageContent)
    {
        try {
            $data = $request->all();
            $this->pageContentService->update(data: $data, pageContent: $pageContent);
            return WebResponse::success(redirect()->route('admin_page_contents.index')
                ->with('success', 'Контент страницы успешно обновлен'));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }
}
