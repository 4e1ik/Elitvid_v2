<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\PageNamesHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\MetaTagRequest;
use App\Models\MetaTag;
use App\Repositories\Admin\MetaTagRepository;
use App\Services\Admin\MetaTagService;

class MetaTagController extends Controller
{
    public function __construct(
        public PageNamesHelper $pageNamesHelper,
        public MetaTagRepository $metaTagRepository,
        public MetaTagService $metaTagService
    ){}

    /**
     * Список всех мета-тегов
     */
    public function index()
    {
        $metaTags = $this->metaTagRepository->getMetaTags();
        $pageNames = $this->pageNamesHelper->getPageNames();

        return view('elitvid.admin.meta_tags.index', compact('metaTags', 'pageNames'));
    }

    /**
     * Страница редактирования мета-тега
     */
    public function edit(MetaTag $metaTag)
    {
        $pageNames = $this->pageNamesHelper->getPageNames();
        $pageName = $pageNames[$metaTag->page] ?? $metaTag->page;

        return view('elitvid.admin.meta_tags.edit', compact('metaTag', 'pageName'));
    }

    /**
     * Обновление мета-тега
     */
    public function update(MetaTagRequest $request, MetaTag $metaTag)
    {
        $this->metaTagService->update(data: $request->all(), metaTag: $metaTag);
        return redirect()->route('admin_metatags')
            ->with('success', 'Мета-теги успешно обновлены');
    }
}
