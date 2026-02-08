<?php

namespace App\Http\Controllers;

use App\Helpers\WebResponse;
use App\Models\Gallery;
use App\Models\Product;
use App\Repositories\PageContentRepository;
use App\Repositories\StaticImagesRepository;
use App\Repositories\StaticPageRepository;

class PotController
{
    public function __construct(
        public StaticPageRepository $staticPageRepository,
        public PageContentRepository $pageContentRepository,
        public StaticImagesRepository $staticImagesRepository,
    ){}

    function pots() {
        try {
            $static_pages = $this->staticPageRepository->getAllStaticPages();
            $pageContent = $this->pageContentRepository->getPageContent(page: 'pots');
            $static_images_arr = $this->staticImagesRepository->getStaticImagesForPage(page: 'pots');

            $pots_images = Gallery::query()
                ->where('type', 'pots')
                ->with(['gallery_images'])
                ->latest()
                ->get();

            return WebResponse::success(view('elitvid.site.pots', compact('pots_images', 'pageContent', 'static_images_arr', 'static_pages')));
        } catch (\Exception $e) {
            return WebResponse::error($e);
        }
    }

    function rectangular_pots() {
        try {
            $static_pages = $this->staticPageRepository->getAllStaticPages();
            $pageContent = $this->pageContentRepository->getPageContent(page: 'rectangular_pots');
            $static_images_arr = $this->staticImagesRepository->getStaticImagesForPage(page: 'rectangular_pots');

            $products = Product::whereIn('active', [1])
                ->whereHas('pot', function ($query) {
                    $query->where('collection', 'Rectangular');
                })
                ->with(['images', 'pot'])
                ->latest()
                ->get();

            return WebResponse::success(view('elitvid.site.pots.rectangular_pots', compact('products', 'pageContent', 'static_images_arr', 'static_pages')));
        } catch (\Exception $e) {
            return WebResponse::error($e);
        }
    }

    function square_pots() {
        try {
            $static_pages = $this->staticPageRepository->getAllStaticPages();
            $pageContent = $this->pageContentRepository->getPageContent(page: 'square_pots');
            $static_images_arr = $this->staticImagesRepository->getStaticImagesForPage(page: 'square_pots');

            $products = Product::whereIn('active', [1])
                ->whereHas('pot', function ($query) {
                    $query->where('collection', 'Square');
                })
                ->with(['images', 'pot'])
                ->latest()
                ->get();

            return WebResponse::success(view('elitvid.site.pots.square_pots', compact('products', 'pageContent', 'static_images_arr', 'static_pages')));
        } catch (\Exception $e) {
            return WebResponse::error($e);
        }
    }

    function round_pots() {
        try {
            $static_pages = $this->staticPageRepository->getAllStaticPages();
            $pageContent = $this->pageContentRepository->getPageContent(page: 'round_pots');
            $static_images_arr = $this->staticImagesRepository->getStaticImagesForPage(page: 'round_pots');

            $products = Product::whereIn('active', [1])
                ->whereHas('pot', function ($query) {
                    $query->where('collection', 'Round');
                })
                ->with(['images', 'pot'])
                ->latest()
                ->get();

            return WebResponse::success(view('elitvid.site.pots.round_pots', compact('products', 'pageContent', 'static_images_arr', 'static_pages')));
        } catch (\Exception $e) {
            return WebResponse::error($e);
        }
    }

    function show_pot_product(string $collection, string $slug)
    {
        try {
            $static_pages = $this->staticPageRepository->getAllStaticPages();
            $product = Product::where('slug', $slug)->with(['images', 'pot'])->first();
            if (!$product) {
                abort(404);
            }
            $rand_products = Product::whereIn('active', [1])
                ->whereHas('pot', function ($query) use ($product) {
                    $query->where('collection', $product->pot->collection);
                })
                ->with(['images'])
                ->inRandomOrder()
                ->get();
            $metaTitle = $product?->meta_title ?? 'Товар';
            $metaDescription = $product?->meta_description ?? 'Описание товара';
            $static_images_arr = $this->staticImagesRepository->getStaticImagesForPage(page: 'pot_product_page');
            $canonicalUrl = route('show_pot_product', ['collection' => $collection, 'slug' => $product->slug]);
            return WebResponse::success(view('elitvid.site.pots.pot_product_page',
                compact('product',
                    'rand_products',
                    'metaTitle',
                    'metaDescription',
                    'static_images_arr',
                    'canonicalUrl',
                    'static_pages'
                )));
        } catch (\Exception $e) {
            return WebResponse::error($e);
        }
    }
}
