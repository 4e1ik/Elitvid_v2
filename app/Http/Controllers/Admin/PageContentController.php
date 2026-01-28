<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePageContentRequest;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\Image;
use App\Models\PageContent;
use App\Repositories\Admin\PageContentRepository;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageContentController extends Controller
{
    public function __construct(
        public ImageService          $imageService,
        public PageContentRepository $pageContentRepository
    )
    {
    }

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
        return DB::transaction(function () use ($request, $pageContent) {
            $data = $request->all();
            $pageContent->update($data);
            $gallery = $pageContent->gallery;
            if (!$gallery) {
                $gallery = Gallery::create([
                    'type' => $pageContent->page,
                    'galleriable_id' => $pageContent->id,
                    'galleriable_type' => PageContent::class,
                    'active' => 1,
                ]);
            }

            if ($data['gallery_images']) {
                $this->imageService->save(
                    images: $data['gallery_images'], model: $gallery, imageData: $data['gallery_descriptions']
                );
            }

            return redirect()->route('admin_page_contents.index')
                ->with('success', 'Контент страницы успешно обновлен');
        });
    }

    /**
     * Обновление описания изображения галереи
     */
    public function updateImageDescription(Request $request, string $page, $imageId)
    {
        $validated = $request->validate([
            'description_image' => 'nullable|string|max:500',
        ]);

        // Пытаемся найти в новой таблице images
        $image = Image::find($imageId);

        if ($image) {
            $image->update($validated);
        } else {
            // Если не найдено, ищем в старой таблице gallery_images
            $galleryImage = GalleryImage::find($imageId);
            if ($galleryImage) {
                $galleryImage->update($validated);
            } else {
                return redirect()->route('admin_page_contents.edit', $page)
                    ->with('error', 'Изображение не найдено');
            }
        }

        return redirect()->route('admin_page_contents.edit', $page)
            ->with('success', 'Описание изображения успешно обновлено');
    }
}
