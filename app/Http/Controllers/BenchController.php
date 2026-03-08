<?php

namespace App\Http\Controllers;

use App\Helpers\WebResponse;
use App\Models\Gallery;
use App\Models\Product;
use App\Repositories\PageContentRepository;
use App\Repositories\StaticImagesRepository;
use App\Repositories\StaticPageRepository;

class BenchController
{
    public function __construct(
        public StaticPageRepository $staticPageRepository,
        public PageContentRepository $pageContentRepository,
        public StaticImagesRepository $staticImagesRepository,
    ){}

    function benches() {
        try {
            $static_pages = $this->staticPageRepository->getAllStaticPages();
            $pageContent = $this->pageContentRepository->getPageContent(page: 'benches');
            $static_images_arr = $this->staticImagesRepository->getStaticImagesForPage(page: 'benches');

            $benches_images = Gallery::query()
                ->where('type', 'benches')
                ->with(['gallery_images'])
                ->latest()
                ->get();

            return WebResponse::success(view('elitvid.site.benches', compact('benches_images', 'pageContent', 'static_images_arr', 'static_pages')));
        } catch (\Exception $e) {
            return WebResponse::error($e);
        }
    }

    function street_furniture_benches() {
        try {
            $static_pages = $this->staticPageRepository->getAllStaticPages();
            $pageContent = $this->pageContentRepository->getPageContent(page: 'street_furniture_benches');
            $static_images_arr = $this->staticImagesRepository->getStaticImagesForPage(page: 'street_furniture_benches');

            $products = Product::whereIn('active', [1])
                ->whereHas('bench', function ($query) {
                    $query->where('collection', 'Street_furniture');
                })
                ->with(['images', 'bench'])
                ->latest()
                ->get();

            return WebResponse::success(view('elitvid.site.benches.street_furniture_benches', compact('products', 'pageContent', 'static_images_arr', 'static_pages')));
        } catch (\Exception $e) {
            return WebResponse::error($e);
        }
    }

    function verona_benches() {
        try {
            $static_pages = $this->staticPageRepository->getAllStaticPages();
            $pageContent = $this->pageContentRepository->getPageContent(page: 'verona_benches');
            $static_images_arr = $this->staticImagesRepository->getStaticImagesForPage(page: 'verona_benches');

            $products = Product::whereIn('active', [1])
                ->whereHas('bench', function ($query) {
                    $query->where('collection', 'Verona');
                })
                ->with(['images', 'bench'])
                ->latest()
                ->get();

            return WebResponse::success(view('elitvid.site.benches.verona_benches', compact('products', 'pageContent', 'static_images_arr', 'static_pages')));
        } catch (\Exception $e) {
            return WebResponse::error($e);
        }
    }

    function stones_benches() {
        try {
            $static_pages = $this->staticPageRepository->getAllStaticPages();
            $pageContent = $this->pageContentRepository->getPageContent(page: 'stones_benches');
            $static_images_arr = $this->staticImagesRepository->getStaticImagesForPage(page: 'stones_benches');

            $products = Product::whereIn('active', [1])
                ->whereHas('bench', function ($query) {
                    $query->where('collection', 'Stones');
                })
                ->with(['images', 'bench'])
                ->latest()
                ->get();

            return WebResponse::success(view('elitvid.site.benches.stones_benches', compact('products', 'pageContent', 'static_images_arr', 'static_pages')));
        } catch (\Exception $e) {
            return WebResponse::error($e);
        }
    }

    function solo_benches() {
        try {
            $static_pages = $this->staticPageRepository->getAllStaticPages();
            $pageContent = $this->pageContentRepository->getPageContent(page: 'solo_benches');
            $static_images_arr = $this->staticImagesRepository->getStaticImagesForPage(page: 'solo_benches');

            $products = Product::whereIn('active', [1])
                ->whereHas('bench', function ($query) {
                    $query->where('collection', 'Solo');
                })
                ->with(['images', 'bench'])
                ->latest()
                ->get();

            return WebResponse::success(view('elitvid.site.benches.solo_benches', compact('products', 'pageContent', 'static_images_arr', 'static_pages')));
        } catch (\Exception $e) {
            return WebResponse::error($e);
        }
    }

    function lines_benches() {
        try {
            $static_pages = $this->staticPageRepository->getAllStaticPages();
            $pageContent = $this->pageContentRepository->getPageContent(page: 'lines_benches');
            $static_images_arr = $this->staticImagesRepository->getStaticImagesForPage(page: 'lines_benches');

            $products = Product::whereIn('active', [1])
                ->whereHas('bench', function ($query) {
                    $query->where('collection', 'lines');
                })
                ->with(['images', 'bench'])
                ->latest()
                ->get();

            return WebResponse::success(view('elitvid.site.benches.lines_benches', compact('products', 'pageContent', 'static_images_arr', 'static_pages')));
        } catch (\Exception $e) {
            return WebResponse::error($e);
        }
    }

    function show_bench_product(string $collection, string $slug)
    {
        try {
            $static_pages = $this->staticPageRepository->getAllStaticPages();
            $product = Product::where('slug', $slug)->with(['images', 'bench'])->first();
            if (!$product) {
                abort(404);
            }
            $rand_products = Product::whereIn('active', [1])
                ->whereHas('bench', function ($query) use ($product) {
                    $query->where('collection', $product->bench->collection);
                })
                ->with(['images'])
                ->inRandomOrder()
                ->get();
            $metaTitle = $product?->meta_title ?? 'Товар';
            $metaDescription = $product?->meta_description ?? 'Описание товара';
            $static_images_arr = $this->staticImagesRepository->getStaticImagesForPage(page: 'bench_product_page');
            $canonicalUrl = route('show_bench_product', ['collection' => $collection, 'slug' => $product->slug]);
            return WebResponse::success(view('elitvid.site.benches.bench_product_page',
                compact('product',
                    'rand_products',
                    'metaTitle',
                    'metaDescription',
                    'static_images_arr',
                    'canonicalUrl',
                    'static_pages',
                    'collection'
                )));
        } catch (\Exception $e) {
            return WebResponse::error($e);
        }
    }
}
