<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\WebResponse;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\Image;
use App\Models\PageContent;
use App\Models\Product;
use App\Models\StaticImages;
use App\Models\StaticPage;

class AdminController extends Controller
{
    public function index() {
        try {
        $stats = [
            'blog_posts' => Blog::count(),
            'active_blog_posts' => Blog::where('active', 1)->count(),
            'products' => Product::count(),
            'active_products' => Product::where('active', 1)->count(),
            'bench_products' => Product::where('product_type', 'bench')->count(),
            'active_bench_products' => Product::where('product_type', 'bench')->where('active', 1)->count(),
            'pot_products' => Product::where('product_type', 'pot')->count(),
            'active_pot_products' => Product::where('product_type', 'pot')->where('active', 1)->count(),
            'galleries' => Gallery::count(),
            'gallery_images' => GalleryImage::count(),
            'product_images' => Image::whereHasMorph('imageable', [Product::class])->count(),
            'static_pages' => StaticPage::count(),
            'page_contents' => PageContent::count(),
            'static_images' => StaticImages::count(),
        ];

        $recent_blogs = Blog::latest()->take(5)->get();

        // Данные для графиков - последние 6 месяцев
        $months = [];
        $blog_data = [];
        $products_data = [];
        $images_data = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthName = $date->format('M');
            $months[] = $monthName;

            $startOfMonth = $date->copy()->startOfMonth();
            $endOfMonth = $date->copy()->endOfMonth();

            $blog_data[] = Blog::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
            $products_data[] = Product::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
            $images_data[] = GalleryImage::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count() +
                            Image::whereHasMorph('imageable', [Product::class])
                                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        }

        // Данные для круговой диаграммы (распределение по типам)
        $chart_data = [
            'months' => $months,
            'blog' => $blog_data,
            'products' => $products_data,
            'images' => $images_data,
            'distribution' => [
                'blog' => $stats['blog_posts'],
                'products' => $stats['products'],
                'bench_products' => $stats['bench_products'],
                'pot_products' => $stats['pot_products'],
                'galleries' => $stats['galleries'],
            ]
        ];

            return WebResponse::success(view('elitvid.admin.admin', compact('stats', 'recent_blogs', 'chart_data')));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }

    public function static_images($page) {
        try {
            $static_images = StaticImages::where('page', $page)->get();
            return WebResponse::success(view('elitvid.admin.static_images.index', compact('static_images')));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }

    public function create($route){
        try {
            $route_name = $route;

            if ($route_name == 'gallery'){
                return WebResponse::success(view('includes.elitvid.admin.create_gallery', compact('route_name')));
            } else if($route_name == 'pots'){
                $productType = 'pot';
                return WebResponse::success(view('includes.elitvid.admin.create_product', compact('productType')));
            } else if($route_name == 'benches'){
                $productType = 'bench';
                return WebResponse::success(view('includes.elitvid.admin.create_product', compact('productType')));
            }
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }

}
