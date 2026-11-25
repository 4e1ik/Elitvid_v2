<?php

namespace App\Http\Controllers;

use App\Helpers\WebResponse;
use App\Repositories\PageContentRepository;
use App\Repositories\StaticImagesRepository;
use App\Repositories\StaticPageRepository;
use App\Repositories\UrnRepository;
use App\Services\CartService;

class UrnController
{
    public function __construct(
        public StaticPageRepository $staticPageRepository,
        public PageContentRepository $pageContentRepository,
        public StaticImagesRepository $staticImagesRepository,
        public UrnRepository $urnRepository,
        public CartService $cartService,
    ){}

    public function urns()
    {
        try {
            $static_pages = $this->staticPageRepository->getAllStaticPages();
            $pageContent = $this->pageContentRepository->getPageContent(page: 'urns');
            $products = $this->urnRepository->active();

            return WebResponse::success(view('elitvid.site.urns', compact('products', 'pageContent', 'static_pages')));
        } catch (\Exception $e) {
            return WebResponse::error($e);
        }
    }

    public function show_urn_product(string $slug)
    {
        $product = $this->urnRepository->findBySlug($slug);
        if (!$product) {
            abort(404);
        }

        try {
            $static_pages = $this->staticPageRepository->getAllStaticPages();
            $rand_products = $this->urnRepository->random();
            $metaTitle = $product->meta_title ?? 'Товар';
            $metaDescription = $product->meta_description ?? 'Описание товара';
            // фактуры и цвета — те же файлы, что у кашпо, подписи из «Картинки › Страница товара кашпо»
            $static_images_arr = $this->staticImagesRepository->getStaticImagesForPage(page: 'pot_product_page');
            $canonicalUrl = route('show_urn_product', ['slug' => $product->slug]);
            $inCart = $this->cartService->has($product->id);

            return WebResponse::success(view('elitvid.site.urns.urn_product_page', compact(
                'product',
                'rand_products',
                'metaTitle',
                'metaDescription',
                'static_images_arr',
                'canonicalUrl',
                'static_pages',
                'inCart'
            )));
        } catch (\Exception $e) {
            return WebResponse::error($e);
        }
    }
}
