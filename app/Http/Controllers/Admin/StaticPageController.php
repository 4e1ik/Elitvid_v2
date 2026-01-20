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
        $data = $request->validated();

        $staticPage = $this->staticPageService->store($data);

        return redirect()->route('static_pages.index')
            ->with('success', 'Статическая страница успешно создана');
    }

    public function edit(StaticPage $staticPage)
    {
        $staticPage->load(['images', 'static_gallery.images']);
        return view('elitvid.admin.static_pages.edit', compact('staticPage'));
    }

    public function update(UpdateStaticPageRequest $request, StaticPage $staticPage)
    {
        $data = $request->all();

        // Обработка active - радио-кнопка всегда отправляет '0' или '1'
        $data['active'] = $request->input('active') == '1';

        // Обработка active для галереи - всегда устанавливаем явное значение
        $data['gallery_active'] = $request->has('gallery_active') && $request->input('gallery_active') == '1';

        // Обработка обновления существующей галереи
        if ($request->has('gallery_id')) {
            $gallery = \App\Models\StaticPageGallery::find($request->input('gallery_id'));
            if ($gallery) {
                $gallery->update(['active' => $data['gallery_active']]);
                return redirect()->route('static_pages.edit', ['static_page' => $staticPage])
                    ->with('success', 'Статус галереи обновлен');
            }
        }

        // Slug обрабатывается в сервисе - если пустой, генерируется из title

        // Обработка файлов
        if ($request->hasFile('main_image')) {
            $data['main_image'] = $request->file('main_image');
        }

        if ($request->hasFile('menu_image')) {
            $data['menu_image'] = $request->file('menu_image');
        }

        if ($request->hasFile('gallery_images')) {
            $data['gallery_images'] = $request->file('gallery_images');
        }

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
