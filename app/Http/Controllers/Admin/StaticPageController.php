<?php

namespace App\Http\Controllers\Admin;

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
        $staticPages = $this->staticPageRepository->getAll();
        return view('elitvid.admin.static_pages.index', compact('staticPages'));
    }

    public function create()
    {
        return view('elitvid.admin.static_pages.create');
    }

    public function store(CreateStaticPageRequest $request)
    {
        $data = $request->all();

        $this->staticPageService->store($data);

        return redirect()->route('static_pages.index')
            ->with('success', 'Статическая страница успешно создана');
    }

    public function edit(StaticPage $staticPage)
    {
        return view('elitvid.admin.static_pages.edit', compact('staticPage'));
    }

    public function update(UpdateStaticPageRequest $request, StaticPage $staticPage)
    {
        $data = $request->all();

        $this->staticPageService->update($data, $staticPage);

        return redirect()->route('static_pages.index')
            ->with('success', 'Статическая страница успешно обновлена');
    }

    public function destroy(StaticPage $staticPage)
    {
        $this->staticPageService->destroy($staticPage);

        return redirect()->route('static_pages.index')
            ->with('success', 'Статическая страница успешно удалена');
    }
}
