<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\StaticPage;
use App\Repositories\PageContentRepository;
use App\Repositories\StaticImagesRepository;
use App\Repositories\StaticPageRepository;

class BollardsAndFencingController
{
    public function __construct(
        public StaticPageRepository $staticPageRepository,
        public PageContentRepository $pageContentRepository,
        public StaticImagesRepository $staticImagesRepository,
    ){}

    function bollards_and_fencing() {
        $static_pages = $this->staticPageRepository->getAllStaticPages();
        $pageContent = $this->pageContentRepository->getPageContent(page: 'bollards_and_fencing');
        
        // Для обратной совместимости получаем галерею через старый способ
        $bollards_and_fencing_images = Gallery::query()
            ->where('type', 'bollards')
            ->with(['gallery_images'])
            ->latest()
            ->get();

        // Статические картинки для alt-тегов, нормализуем пути
        $static_images = \App\Models\StaticImages::where('page', 'bollards_and_fencing')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            // убираем ведущие ./ и дублируем варианты путей
            $normalizedPath = ltrim($static_image->image, './');

            // без слеша в начале
            $static_images_arr[$normalizedPath] = $static_image->description_image;

            // со слешем в начале
            if (!str_starts_with($normalizedPath, '/')) {
                $static_images_arr['/' . $normalizedPath] = $static_image->description_image;
            }
        }
        
        // Получаем StaticPage для title и description (если нужно)
        try {
            $staticPage = StaticPage::where('slug', 'bollards_and_fencing')->first();
        } catch (\Exception $e) {
            $staticPage = null;
        }
        
        return view('elitvid.site.bollards_and_fencing', compact('bollards_and_fencing_images', 'pageContent', 'static_images_arr', 'staticPage', 'static_pages'));
    }
}
