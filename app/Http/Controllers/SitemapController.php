<?php

namespace App\Http\Controllers;

use App\Models\BenchProduct;
use App\Models\Blog;
use App\Models\PotProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

class SitemapController extends Controller
{
    public function index()
    {
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
            'loc' => URL::to(route('rotundas_and_colonnades')),
            'lastmod' => Carbon::now()->toAtomString(),
            'changefreq' => 'daily',
            'priority' => '0.8'
        ];


        $urls[] = [
            'loc' => URL::to(route('parklets_and_canopies')),
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
            'loc' => URL::to(route('pillars_and_covers')),
            'lastmod' => Carbon::now()->toAtomString(),
            'changefreq' => 'daily',
            'priority' => '0.8'
        ];


        $urls[] = [
            'loc' => URL::to(route('facade_stucco_molding_and_panels')),
            'lastmod' => Carbon::now()->toAtomString(),
            'changefreq' => 'daily',
            'priority' => '0.8'
        ];

        $urls[] = [
            'loc' => URL::to(route('small_architectural_forms')),
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
            'loc' => URL::to(route('rectangular_pots')),
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

        // Add dynamic pages
//        $posts = \App\Models\Post::all();
        $benches = BenchProduct::where('active', 1)->get();
        foreach ($benches as $bench) {
            $collection = $bench->collection;
            $benchRoutes = [
                'Verona' => route('verona_benches'),
                'Stones' => route('stones_benches'),
                'lines' => route('lines_benches'),
                'Solo' => route('solo_benches'),
                'Street_furniture' => route('street_furniture_benches'),
            ];

            $urls[] = [
                'loc' => URL::to($benchRoutes[$collection].'/'.$bench->id),
                'lastmod' => $bench->updated_at->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.4'
            ];
        }

        $pots = PotProduct::where('active', 1)->get();
        foreach ($pots as $pot) {
            $collection = $pot->collection;
            $potRoutes = [
                'Square' => route('square_pots'),
                'Round' => route('round_pots'),
                'Rectangular' => route('rectangular_pots'),
            ];

            $urls[] = [
                'loc' => URL::to($potRoutes[$collection].'/'.$pot->id),
                'lastmod' => $pot->updated_at->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.4'
            ];
        }

        $blogs = Blog::where('active', 1)->get();
        foreach ($blogs as $blog) {

            $urls[] = [
                'loc' => URL::to(route('blog_posts').'/post/'.$blog->id),
                'lastmod' => $blog->updated_at->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.4'
            ];
        }

        // Generate XML
        $xml = $this->generateSitemap($urls);

        return response($xml, 200)
//            ->header('Content-Type', 'application/xml');
            ->header('Content-Type', 'text/xml; charset=utf-8');
    }

    private function generateSitemap($urls)
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset/>');
        $xml->addAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        foreach ($urls as $url) {
            $urlTag = $xml->addChild('url');
            $urlTag->addChild('loc', $url['loc']);
            $urlTag->addChild('lastmod', $url['lastmod']);
            $urlTag->addChild('changefreq', $url['changefreq']);
            $urlTag->addChild('priority', $url['priority']);
        }

        return $xml->asXML();
    }
}
