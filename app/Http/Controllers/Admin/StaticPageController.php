<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\WebResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateStaticPageRequest;
use App\Http\Requests\UpdateStaticPageRequest;
use App\Repositories\Admin\StaticPageRepository;
use App\Services\Admin\StaticPageService;
use App\Models\StaticPage;

class StaticPageController extends Controller
{
    public function __construct(
        public StaticPageService $staticPageService,
        public StaticPageRepository $staticPageRepository,
    ){}

    public function index()
    {
        try {
            $staticPages = $this->staticPageRepository->getAll();
            return WebResponse::success(view('elitvid.admin.static_pages.index', compact('staticPages')));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }

    public function create()
    {
        try {
            return WebResponse::success(view('elitvid.admin.static_pages.create'));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }

    public function store(CreateStaticPageRequest $request)
    {
        try {
            $data = $request->all();
            $this->staticPageService->store($data);
            return WebResponse::success(redirect()->route('static_pages.index')
                ->with('success', 'Статическая страница успешно создана'));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }

    public function edit(StaticPage $staticPage)
    {
        try {
            return WebResponse::success(view('elitvid.admin.static_pages.edit', compact('staticPage')));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }

    public function update(UpdateStaticPageRequest $request, StaticPage $staticPage)
    {
        try {
            $data = $request->all();
            $this->staticPageService->update($data, $staticPage);
            return WebResponse::success(redirect()->route('static_pages.index')
                ->with('success', 'Статическая страница успешно обновлена'));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }

    public function destroy(StaticPage $staticPage)
    {
        try {
            $this->staticPageService->destroy($staticPage);
            return WebResponse::success(redirect()->route('static_pages.index')
                ->with('success', 'Статическая страница успешно удалена'));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }
}
