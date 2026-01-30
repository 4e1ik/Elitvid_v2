<?php

namespace App\Http\Controllers;

use App\Helpers\WebResponse;
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
        try {
            $static_pages = $this->staticPageRepository->getAllStaticPages();
            $pageContent = $this->pageContentRepository->getPageContent(page: 'bollards_and_fencing');
            $static_images = \App\Models\StaticImages::where('page', 'bollards_and_fencing')->get();
            $static_images_arr = [];
            foreach ($static_images as $static_image) {
                $normalizedPath = ltrim($static_image->image, './');
                $static_images_arr[$normalizedPath] = $static_image->description_image;
                if (!str_starts_with($normalizedPath, '/')) {
                    $static_images_arr['/' . $normalizedPath] = $static_image->description_image;
                }
            }

            $staticPage = StaticPage::where('slug', 'bollards_and_fencing')->first();

            return WebResponse::success(view('elitvid.site.bollards_and_fencing', compact( 'pageContent', 'static_images_arr', 'staticPage', 'static_pages')));
        } catch (\Exception $e) {
            return WebResponse::error($e);
        }
    }
}
