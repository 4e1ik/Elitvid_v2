<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\PageNamesHelper;
use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\Image;
use App\Models\PageContent;
use Illuminate\Http\Request;

class PageContentController extends Controller
{
    public function __construct(
        public PageNamesHelper $pageNamesHelper
    ){}

    /**
     * Список всех страниц с контентом
     */
    public function index()
    {
        $pageContents = PageContent::all();
        $pageNames = $this->pageNamesHelper->getPageNames();
        
        // Получаем все возможные страницы из helper
        $allPages = array_keys($pageNames);
        
        // Создаем коллекцию всех страниц (существующих и несуществующих)
        $pages = collect($allPages)->map(function ($page) use ($pageContents, $pageNames) {
            $content = $pageContents->firstWhere('page', $page);
            // Загружаем галерею через полиморфную связь, если контент существует
            if ($content) {
                $content->load('gallery');
            }
            return [
                'page' => $page,
                'name' => $pageNames[$page] ?? $page,
                'content' => $content,
                'has_content' => $content !== null,
            ];
        });

        return view('elitvid.admin.page_contents.index', compact('pages', 'pageNames'));
    }

    /**
     * Страница редактирования контента
     */
    public function edit(string $page)
    {
        $pageContent = PageContent::with('gallery.images')->firstOrNew(['page' => $page]);
        $pageNames = $this->pageNamesHelper->getPageNames();
        $pageName = $pageNames[$page] ?? $page;
        
        // Получаем галерею через полиморфную связь
        $gallery = $pageContent->gallery;
        
        // Если галереи нет через полиморфную связь, ищем по типу страницы
        if (!$gallery) {
            $galleryType = $this->getGalleryTypeByPage($page);
            if ($galleryType) {
                // Находим галерею этого типа (теперь должна быть только одна)
                $gallery = Gallery::where('type', $galleryType)
                    ->with(['images', 'gallery_images'])
                    ->first();
            }
        } else {
            // Загружаем изображения, если галерея есть
            $gallery->load(['images', 'gallery_images']);
        }
        
        // Получаем все изображения из галереи
        $allImages = collect();
        if ($gallery) {
            // Используем images (новая структура), если есть, иначе gallery_images (старая)
            if ($gallery->images && $gallery->images->count() > 0) {
                $allImages = $gallery->images;
            } elseif ($gallery->gallery_images && $gallery->gallery_images->count() > 0) {
                $allImages = $gallery->gallery_images;
            }
        }

        return view('elitvid.admin.page_contents.edit', compact('pageContent', 'pageName', 'page', 'gallery', 'allImages'));
    }

    /**
     * Обновление контента страницы
     */
    public function update(Request $request, string $page)
    {
        $validated = $request->validate([
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'category_description' => 'nullable|string',
        ]);

        $pageContent = PageContent::updateOrCreate(
            ['page' => $page],
            $validated
        );

        return redirect()->route('admin_page_contents.index')
            ->with('success', 'Контент страницы успешно обновлен');
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

    /**
     * Маппинг страниц на типы галерей (для обратной совместимости)
     */
    private function getGalleryTypeByPage(string $page): ?string
    {
        $mapping = [
            'main' => 'main_page',
            'pots' => 'pots',
            'benches' => 'benches',
            'decorations' => 'decorative_elements',
            'bollards_and_fencing' => 'bollards',
        ];

        return $mapping[$page] ?? null;
    }
}
