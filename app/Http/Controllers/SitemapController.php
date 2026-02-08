<?php

namespace App\Http\Controllers;

use App\Helpers\WebResponse;
use App\Models\Blog;
use App\Models\Product;
use App\Models\StaticPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

class SitemapController extends Controller
{
    public function index()
    {
        try {
        // Array to store URLs
        $urls = [];

        // Add static pages
        $urls[] = [
            'loc' => URL::to(route('home')),
            'lastmod' => Carbon::now()->toAtomString(),
            'changefreq' => 'daily',
            'priority' => '1.0'
        ];

        $urls[] = [
            'loc' => URL::to(route('directions')),
            'lastmod' => Carbon::now()->toAtomString(),
            'changefreq' => 'daily',
            'priority' => '1.0'
        ];

        $urls[] = [
            'loc' => URL::to(route('blog_posts')),
            'lastmod' => Carbon::now()->toAtomString(),
            'changefreq' => 'daily',
            'priority' => '0.8'
        ];

        $urls[] = [
            'loc' => URL::to(route('pots')),
            'lastmod' => Carbon::now()->toAtomString(),
            'changefreq' => 'daily',
            'priority' => '0.8'
        ];


        $urls[] = [
            'loc' => URL::to(route('benches')),
            'lastmod' => Carbon::now()->toAtomString(),
            'changefreq' => 'daily',
            'priority' => '0.8'
        ];


        $urls[] = [
            'loc' => URL::to(route('bollards_and_fencing')),
            'lastmod' => Carbon::now()->toAtomString(),
            'changefreq' => 'daily',
            'priority' => '0.8'
        ];


        $urls[] = [
            'loc' => URL::to(route('decorations')),
            'lastmod' => Carbon::now()->toAtomString(),
            'changefreq' => 'daily',
            'priority' => '1.0'
        ];

        $urls[] = [
            'loc' => URL::to('https://elitvid.com/elitvid_assets/newDesign/newDesign/files/pots.pdf'),
            'lastmod' => Carbon::now()->toAtomString(),
            'changefreq' => 'daily',
            'priority' => '0.2'
        ];

        $urls[] = [
            'loc' => URL::to(route('rectangular_pots')),
            'lastmod' => Carbon::now()->toAtomString(),
            'changefreq' => 'daily',
            'priority' => '0.6'
        ];

        $urls[] = [
            'loc' => URL::to(route('round_pots')),
            'lastmod' => Carbon::now()->toAtomString(),
            'changefreq' => 'daily',
            'priority' => '0.6'
        ];

        $urls[] = [
            'loc' => URL::to(route('square_pots')),
            'lastmod' => Carbon::now()->toAtomString(),
            'changefreq' => 'daily',
            'priority' => '0.6'
        ];

        $urls[] = [
            'loc' => URL::to('https://elitvid.com/elitvid_assets/newDesign/newDesign/files/benches.pdf'),
            'lastmod' => Carbon::now()->toAtomString(),
            'changefreq' => 'daily',
            'priority' => '0.2'
        ];

        $urls[] = [
            'loc' => URL::to(route('verona_benches')),
            'lastmod' => Carbon::now()->toAtomString(),
            'changefreq' => 'daily',
            'priority' => '0.6'
        ];

        $urls[] = [
            'loc' => URL::to(route('stones_benches')),
            'lastmod' => Carbon::now()->toAtomString(),
            'changefreq' => 'daily',
            'priority' => '0.6'
        ];

        $urls[] = [
            'loc' => URL::to(route('lines_benches')),
            'lastmod' => Carbon::now()->toAtomString(),
            'changefreq' => 'daily',
            'priority' => '0.6'
        ];

        $urls[] = [
            'loc' => URL::to(route('solo_benches')),
            'lastmod' => Carbon::now()->toAtomString(),
            'changefreq' => 'daily',
            'priority' => '0.6'
        ];

        $urls[] = [
            'loc' => URL::to(route('street_furniture_benches')),
            'lastmod' => Carbon::now()->toAtomString(),
            'changefreq' => 'daily',
            'priority' => '0.6'
        ];

        // Статические страницы из БД (active)
        $staticPages = StaticPage::where('active', true)->get();
        foreach ($staticPages as $page) {
            $urls[] = [
                'loc' => URL::to(route('static_page', ['slug' => $page->slug])),
                'lastmod' => $page->updated_at->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.6'
            ];
        }

        // Add dynamic pages
        $benches = Product::where('active', 1)
            ->where('product_type', 'bench')
            ->with('bench')
            ->get();
        $benchCollectionSlugs = [
            'Verona' => 'verona_benches',
            'Stones' => 'stones_benches',
            'lines' => 'lines_benches',
            'Solo' => 'solo_benches',
            'Street_furniture' => 'street_furniture_benches',
        ];
        foreach ($benches as $bench) {
            if (!$bench->bench) continue;
            $collection = $bench->bench->collection;
            if (isset($benchCollectionSlugs[$collection])) {
                $urls[] = [
                    'loc' => URL::to(route('show_bench_product', ['collection' => $benchCollectionSlugs[$collection], 'slug' => $bench->slug])),
                    'lastmod' => $bench->updated_at->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.4'
                ];
            }
        }

        $pots = Product::where('active', 1)
            ->where('product_type', 'pot')
            ->with('pot')
            ->get();
        $potCollectionSlugs = [
            'Square' => 'square_pots',
            'Round' => 'round_pots',
            'Rectangular' => 'rectangular_pots',
        ];
        foreach ($pots as $pot) {
            if (!$pot->pot) continue;
            $collection = $pot->pot->collection;
            if (isset($potCollectionSlugs[$collection])) {
                $urls[] = [
                    'loc' => URL::to(route('show_pot_product', ['collection' => $potCollectionSlugs[$collection], 'slug' => $pot->slug])),
                    'lastmod' => $pot->updated_at->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.4'
                ];
            }
        }

        $blogs = Blog::where('active', 1)->get();
        $blogSlugsExclude = ['tsuatsuatsuatsua']; // тестовые/мусорные slug — не попадают в sitemap
        foreach ($blogs as $blog) {
            if (in_array($blog->slug, $blogSlugsExclude, true)) {
                continue;
            }
            $urls[] = [
                'loc' => URL::to(route('show_blog_post', ['slug' => $blog->slug])),
                'lastmod' => $blog->updated_at->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.4'
            ];
        }

        // Generate XML
        $xml = $this->generateSitemap($urls);

        return WebResponse::success(response($xml, 200)
            ->header('Content-Type', 'text/xml; charset=utf-8'));
        } catch (\Exception $e) {
            return WebResponse::error($e);
        }
    }

    private function generateSitemap($urls)
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset/>');
        $xml->addAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        foreach ($urls as $url) {
            $urlTag = $xml->addChild('url');
            $urlTag->addChild('loc', trim($url['loc']));
            $urlTag->addChild('lastmod', trim($url['lastmod']));
            $urlTag->addChild('changefreq', trim($url['changefreq']));
            $urlTag->addChild('priority', trim((string) $url['priority']));
        }

        return $xml->asXML();
    }
}
