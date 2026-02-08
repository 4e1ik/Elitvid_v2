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
use App\Models\Mail;
use App\Models\Bench;
use App\Models\Pot;

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
            'active_static_pages' => StaticPage::where('active', 1)->count(),
            'page_contents' => PageContent::count(),
            'static_images' => StaticImages::count(),
        ];

        // История последних действий: посты блога, страницы, продукты
        $recent_activity = collect()
            ->merge(
                Blog::latest()->take(5)->get()->map(fn ($item) => (object)[
                    'type_label' => 'Пост блога',
                    'type' => 'blog',
                    'title' => $item->title,
                    'excerpt' => $item->description ?? '',
                    'created_at' => $item->created_at,
                    'active' => (bool) $item->active,
                    'edit_url' => route('blogs.edit', $item),
                ])
            )
            ->merge(
                StaticPage::latest()->take(5)->get()->map(fn ($item) => (object)[
                    'type_label' => 'Страница',
                    'type' => 'static_page',
                    'title' => $item->title ?? $item->slug,
                    'excerpt' => \Illuminate\Support\Str::limit(strip_tags($item->subtitle ?? $item->content ?? ''), 100),
                    'created_at' => $item->created_at,
                    'active' => (bool) $item->active,
                    'edit_url' => route('static_pages.edit', $item),
                ])
            )
            ->merge(
                Product::latest()->take(5)->get()->map(fn ($item) => (object)[
                    'type_label' => 'Продукт',
                    'type' => 'product',
                    'title' => $item->name,
                    'excerpt' => \Illuminate\Support\Str::limit($item->meta_description ?? '', 100),
                    'created_at' => $item->created_at,
                    'active' => (bool) $item->active,
                    'edit_url' => route('products.edit', $item),
                ])
            )
            ->sortByDesc(fn ($item) => $item->created_at)
            ->take(12)
            ->values();

        // Данные для графика заявок по неделям (последние 8 недель)
        $weeks_labels = [];
        $mails_per_week = [];
        for ($i = 7; $i >= 0; $i--) {
            $weekStart = now()->subWeeks($i)->startOfWeek();
            $weekEnd = $weekStart->copy()->endOfWeek();
            $weeks_labels[] = $weekStart->format('d.m');
            $mails_per_week[] = Mail::whereBetween('created_at', [$weekStart, $weekEnd])->count();
        }

        // Данные для круговой диаграммы (распределение по типам)
        $chart_data = [
            'weeks' => $weeks_labels,
            'mails_per_week' => $mails_per_week,
            'distribution' => [
                'blog' => $stats['blog_posts'],
                'products' => $stats['products'],
                'bench_products' => $stats['bench_products'],
                'pot_products' => $stats['pot_products'],
                'galleries' => $stats['galleries'],
            ]
        ];

            return WebResponse::success(view('elitvid.admin.admin', compact('stats', 'recent_activity', 'chart_data')));
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

            if ($route_name == 'pots'){
                $productType = 'pot';
                return WebResponse::success(view('includes.elitvid.admin.create_product', compact('productType')));
            }
            if ($route_name == 'benches'){
                $productType = 'bench';
                return WebResponse::success(view('includes.elitvid.admin.create_product', compact('productType')));
            }

            abort(404);
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }

}
