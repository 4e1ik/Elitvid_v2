<?php

namespace App\Http\Controllers;

use App\Models\BenchProduct;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\MetaTag;
use App\Models\PotProduct;
use App\Models\StaticImages;
use App\Models\StaticPage;
use Illuminate\Support\Facades\Response;

class MainController extends Controller
{
    function index() {
        $gallery = Gallery::query()->with(['gallery_images'])->latest()->get();
        $main_page_images = $gallery->where('type', 'main_page');
        $metaTags = MetaTag::where('page', 'main')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Главная страница';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание главной страницы';
        $categories = Category::where('page', 'main')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        $static_images = StaticImages::where('page', 'index')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
        }
        return view('elitvid.site.index', compact( 'main_page_images', 'metaTitle', 'metaDescription', 'category', 'static_images_arr'));
    }

    function test()
    {
        return view('elitvid.site.test');
    }

    function sitemap()
    {
        $filePath = public_path('sitemap.xml');
        if (!file_exists($filePath)) {
            abort(404, 'Sitemap not found.');
        }
        return Response::file($filePath, [
            'Content-Type' => 'application/xml',
        ]);
    }

    function bollards_and_fencing() {
        $gallery = Gallery::query()->with(['gallery_images'])->latest()->get();
        $bollards_and_fencing_images = $gallery->where('type', 'bollards');
        $metaTags = MetaTag::where('page', 'bollards_and_fencing')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Болларды и ограждения';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание боллардов и ограждений';
        $categories = Category::where('page', 'bollards_and_fencing')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        $static_images = StaticImages::where('page', 'bollards_and_fencing')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
        }
        try {
            $staticPage = StaticPage::where('page', 'bollards_and_fencing')->first();
        } catch (\Exception $e) {
            $staticPage = null;
        }
        return view('elitvid.site.bollards_and_fencing', compact('bollards_and_fencing_images', 'metaTitle', 'metaDescription', 'category', 'static_images_arr', 'staticPage'));
    }

    function facade_stucco_molding_and_panels() {
        $gallery = Gallery::query()->with(['gallery_images'])->latest()->get();
        $facade_walls_images = $gallery->where('type', 'facade_walls');
        $metaTags = MetaTag::where('page', 'facade_stucco_molding_and_panels')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Фасадная лепнина и панели';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание фасадной лепнины и панелей';
        $categories = Category::where('page', 'facade_stucco_molding_and_panels')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        $static_images = StaticImages::where('page', 'facade_stucco_molding_and_panels')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
        }
        try {
            $staticPage = StaticPage::where('page', 'facade_stucco_molding_and_panels')->first();
        } catch (\Exception $e) {
            $staticPage = null;
        }
        return view('elitvid.site.facade_stucco_molding_and_panels', compact('facade_walls_images', 'metaTitle', 'metaDescription', 'category', 'static_images_arr', 'staticPage'));
    }

    function parklets_and_canopies() {
        $gallery = Gallery::query()->with(['gallery_images'])->latest()->get();
        $parklets_and_naves_images = $gallery->where('type', 'parklets_and_naves');
        $metaTags = MetaTag::where('page', 'parklets_and_canopies')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Парклеты и навесы';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание парклетов и навесов';
        $categories = Category::where('page', 'parklets_and_canopies')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        $static_images = StaticImages::where('page', 'parklets_and_canopies')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
        }
        try {
            $staticPage = StaticPage::where('page', 'parklets_and_canopies')->first();
        } catch (\Exception $e) {
            $staticPage = null;
        }
        return view('elitvid.site.parklets_and_canopies',compact('parklets_and_naves_images', 'metaTitle', 'metaDescription', 'category', 'static_images_arr', 'staticPage'));
    }

    function pillars_and_covers() {
        $gallery = Gallery::query()->with(['gallery_images'])->latest()->get();
        $columns_and_panels_images = $gallery->where('type', 'columns_and_panels');
        $metaTags = MetaTag::where('page', 'pillars_and_covers')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Столбы и накрывки';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание столбов и накрывок';
        $categories = Category::where('page', 'pillars_and_covers')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        $static_images = StaticImages::where('page', 'pillars_and_covers')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
        }
        try {
            $staticPage = StaticPage::where('page', 'pillars_and_covers')->first();
        } catch (\Exception $e) {
            $staticPage = null;
        }
        return view('elitvid.site.pillars_and_covers', compact('columns_and_panels_images', 'metaTitle', 'metaDescription', 'category', 'static_images_arr', 'staticPage'));
    }

    function rotundas_and_colonnades() {
        $gallery = Gallery::query()->with(['gallery_images'])->latest()->get();
        $rotundas_and_colonnades_images = $gallery->where('type', 'rotundas');
        $metaTags = MetaTag::where('page', 'rotundas_and_colonnades')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Ротонды и колонны';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание ротонд и колонн';
        $categories = Category::where('page', 'rotundas_and_colonnades')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        $static_images = StaticImages::where('page', 'rotundas_and_colonnades')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
        }
        try {
            $staticPage = StaticPage::where('page', 'rotundas_and_colonnades')->first();
        } catch (\Exception $e) {
            $staticPage = null;
        }
        return view('elitvid.site.rotundas_and_colonnades', compact('rotundas_and_colonnades_images', 'metaTitle', 'metaDescription', 'category', 'static_images_arr', 'staticPage'));
    }

    function about() {
        return view('elitvid.site.about');
    }

    function show_pot_product($collection, $id){
        $products = PotProduct::query()->with('pot_images')->where('id', $id)->latest()->get();
        $rand_products = PotProduct::query()->with('pot_images')->where('active', '1')->inRandomOrder()->get();
        $i = 1;
        $j = 1;

        $rows = [];
        $arr_size = ['','','','',''];
        $arr_weight = ['','','','',''];
        $arr_price = ['','','','',''];
        foreach ($products as $product) {
            $p_size = explode("|", $product->size);
            $p_weight = explode("|", $product->weight);
            $p_price = explode("|", $product->price);

            for($i=0;$i<5;$i++){
                if(empty($p_size[$i])) {
                    $arr_size[$i] = '';
                }  else {
                    $arr_size[$i] = $p_size[$i];
                }

                if(empty($p_weight[$i])){
                    $arr_weight[$i] = '';
                }  else {
                    $arr_weight[$i] = $p_weight[$i];
                }

                if(empty($p_price[$i])){
                    $arr_price[$i] = '';
                }  else {
                    $arr_price[$i] = $p_price[$i];
                }
                $rows[$i] = (empty($product->size) ? '' : $arr_size[$i]).'|'.(empty($product->weight) ? '' : $arr_weight[$i]).'|'.(empty($product->price) ? '' : $arr_price[$i]);
            }
        }

        $count = count($rows);

        $metaTitle = $products->first()?->meta_title ?? 'Товар';
        $metaDescription = $products->first()?->meta_description ?? 'Описание товара';
        $static_images = StaticImages::where('page', 'pot_product_page')->get();
        $static_images_arr = [];
        $canonicalUrl = route('show_pot_product', ['collection' => $collection,'id' => $id]);
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
        }
        return view('elitvid.site.pots.pot_product_page',
            compact('products',
                'i',
                'j',
                'rows',
                'count',
                'rand_products',
                'metaTitle',
                'metaDescription',
                'static_images_arr',
                'canonicalUrl'
            ));
    }

    function show_bench_product($collection, $id){
        $products = benchProduct::query()->with('bench_images')->where('id', $id)->latest()->get();
        $rand_products = benchProduct::query()->with('bench_images')->where('active', '1')->inRandomOrder()->get();
        $i = 1;
        $j = 1;

        $rows = [];
        $arr_size = ['','','','',''];
        $arr_weight = ['','','','',''];
        $arr_price = ['','','','',''];
        foreach ($products as $product) {
            $p_size = explode("|", $product->size);
            $p_weight = explode("|", $product->weight);
            $p_price = explode("|", $product->price);

            for($i=0;$i<5;$i++){
                if(empty($p_size[$i])) {
                    $arr_size[$i] = '';
                }  else {
                    $arr_size[$i] = $p_size[$i];
                }

                if(empty($p_weight[$i])){
                    $arr_weight[$i] = '';
                }  else {
                    $arr_weight[$i] = $p_weight[$i];
                }

                if(empty($p_price[$i])){
                    $arr_price[$i] = '';
                }  else {
                    $arr_price[$i] = $p_price[$i];
                }
                $rows[$i] = (empty($product->size) ? '' : $arr_size[$i]).'|'.(empty($product->weight) ? '' : $arr_weight[$i]).'|'.(empty($product->price) ? '' : $arr_price[$i]);
            }
        }

        $count = count($rows);

        $metaTitle = $products->first()?->meta_title ?? 'Товар';
        $metaDescription = $products->first()?->meta_description ?? 'Описание товара';
        $static_images = StaticImages::where('page', 'bench_product_page')->get();
        $static_images_arr = [];
        $canonicalUrl = route('show_bench_product', ['collection' => $collection,'id' => $id]);
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
        }
        return view('elitvid.site.benches.bench_product_page',
            compact('products',
                'i',
                'j',
                'rows',
                'count',
                'rand_products',
                'metaTitle',
                'metaDescription',
                'static_images_arr',
                'canonicalUrl',
            ));
    }

    function benches() {

        $gallery = Gallery::query()->with(['gallery_images'])->latest()->get();
        $benches_images = $gallery->where('type', 'benches');
        $metaTags = MetaTag::where('page', 'benches')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Скамейки';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание скамеек';
        $categories = Category::where('page', 'benches')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        $static_images = StaticImages::where('page', 'benches')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
        }
        return view('elitvid.site.benches', compact('benches_images', 'metaTitle', 'metaDescription', 'category', 'static_images_arr'));
    }

    function street_furniture_benches() {

        $benches = BenchProduct::query()->whereIn('active', [1])->with(['bench_images'])->latest()->get();
        $street_furniture_benches = $benches->where('collection', 'Street_furniture');
        $metaTags = MetaTag::where('page', 'street_furniture_benches')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Коллекция Street Furniture';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание коллекции Street Furniture';
        $categories = Category::where('page', 'street_furniture_benches')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        $static_images = StaticImages::where('page', 'street_furniture_benches')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
        }
        return view('elitvid.site.benches.street_furniture_benches', compact('street_furniture_benches', 'metaTitle', 'metaDescription', 'category', 'static_images_arr'));
    }

    function verona_benches() {

        $benches = BenchProduct::query()->whereIn('active', [1])->with(['bench_images'])->latest()->get();
        $verona_benches = $benches->where('collection', 'Verona');
        $metaTags = MetaTag::where('page', 'verona_benches')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Коллекция Verona';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание коллекции Verona';
        $categories = Category::where('page', 'verona_benches')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        $static_images = StaticImages::where('page', 'verona_benches')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
        }
        return view('elitvid.site.benches.verona_benches', compact('verona_benches', 'metaTitle', 'metaDescription', 'category', 'static_images_arr'));
    }

    function stones_benches() {

        $benches = BenchProduct::query()->whereIn('active', [1])->with(['bench_images'])->latest()->get();
        $stones_benches = $benches->where('collection', 'Stones');
        $metaTags = MetaTag::where('page', 'stones_benches')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Коллекция Stones';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание коллекции Stones';
        $categories = Category::where('page', 'stones_benches')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        $static_images = StaticImages::where('page', 'stones_benches')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
        }
        return view('elitvid.site.benches.stones_benches', compact('stones_benches', 'metaTitle', 'metaDescription', 'category', 'static_images_arr'));
    }

    function solo_benches() {

        $benches = BenchProduct::query()->whereIn('active', [1])->with(['bench_images'])->latest()->get();
        $solo_benches = $benches->where('collection', 'Solo');
        $metaTags = MetaTag::where('page', 'solo_benches')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Коллекция Solo';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание коллекции Solo';
        $categories = Category::where('page', 'solo_benches')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        $static_images = StaticImages::where('page', 'solo_benches')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
        }
        return view('elitvid.site.benches.solo_benches', compact('solo_benches', 'metaTitle', 'metaDescription', 'category', 'static_images_arr'));
    }

    function lines_benches() {

        $benches = BenchProduct::query()->whereIn('active', [1])->with(['bench_images'])->latest()->get();
        $lines_benches = $benches->where('collection', 'lines');
        $metaTags = MetaTag::where('page', 'lines_benches')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Коллекция Lines';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание коллекции Lines';
        $categories = Category::where('page', 'lines_benches')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        $static_images = StaticImages::where('page', 'lines_benches')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
        }
        return view('elitvid.site.benches.lines_benches', compact('lines_benches', 'metaTitle', 'metaDescription', 'category', 'static_images_arr'));
    }

    function directions() {
        $metaTags = MetaTag::where('page', 'directions')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Наши направления';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание направлений';
        $categories = Category::where('page', 'directions')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        $static_images = StaticImages::where('page', 'directions')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
        }
        return view('elitvid.site.directions', compact('metaTitle', 'metaDescription', 'category', 'static_images_arr'));
    }

    function decorations()
    {
        $gallery = Gallery::query()->with(['gallery_images'])->latest()->get();
        $decorative_elements_images = $gallery->where('type', 'decorative_elements');
        $metaTags = MetaTag::where('page', 'decorations')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Декоративные элементы';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание декоративных элементов';
        $categories = Category::where('page', 'decorations')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        $static_images = StaticImages::where('page', 'decorations')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
        }
        return view('elitvid.site.decorations', compact('decorative_elements_images', 'metaTitle', 'metaDescription', 'category', 'static_images_arr'));
    }

    function pots() {

        $gallery = Gallery::query()->with(['gallery_images'])->latest()->get();
        $pots_images = $gallery->where('type', 'pots');
        $metaTags = MetaTag::where('page', 'pots')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Кашпо';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание кашпо';
        $categories = Category::where('page', 'pots')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        $static_images = StaticImages::where('page', 'pots')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
        }
        return view('elitvid.site.pots', compact('pots_images', 'metaTitle', 'metaDescription', 'category', 'static_images_arr'));
    }

    function rectangular_pots() {
        $pots = PotProduct::query()->whereIn('active', [1])->with(['pot_images'])->latest()->get();
        $rectangular_pots = $pots->where('collection', 'Rectangular');
        $metaTags = MetaTag::where('page', 'rectangular_pots')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Прямоугольные кашпо';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание прямоугольных кашпо';
        $categories = Category::where('page', 'rectangular_pots')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        $static_images = StaticImages::where('page', 'rectangular_pots')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
        }
        return view('elitvid.site.pots.rectangular_pots', compact('rectangular_pots', 'metaTitle', 'metaDescription', 'category', 'static_images_arr'));
    }

    function square_pots() {
        $pots = PotProduct::whereIn('active', [1])->latest()->get();
        $square_pots = $pots->where('collection', 'Square');
        $metaTags = MetaTag::where('page', 'square_pots')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Квадратные кашпо';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание квадратных кашпо';
        $categories = Category::where('page', 'square_pots')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        $static_images = StaticImages::where('page', 'square_pots')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
        }
        return view('elitvid.site.pots.square_pots', compact('square_pots', 'metaTitle', 'metaDescription', 'category', 'static_images_arr'));
    }

    function round_pots() {
        $pots = PotProduct::query()->whereIn('active', [1])->with(['pot_images'])->latest()->get();
        $round_pots = $pots->where('collection', 'Round');
        $metaTags = MetaTag::where('page', 'round_pots')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Круглые кашпо';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание круглых кашпо';
        $categories = Category::where('page', 'round_pots')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        $static_images = StaticImages::where('page', 'round_pots')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
        }
        return view('elitvid.site.pots.round_pots', compact('round_pots', 'metaTitle', 'metaDescription', 'category', 'static_images_arr'));
    }

    function blog_posts()
    {
        $blogs = Blog::whereIn('active', [1])->latest()->get();
        $metaTags = MetaTag::where('page', 'blog')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Блог';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание блога';
        $categories = Category::where('page', 'blog')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        return view('elitvid.site.blog.blog', compact('blogs', 'metaTitle', 'metaDescription', 'category'));
    }

    function show_blog_post($id){
        $blog = Blog::where('id', $id)->first();
        if (!$blog) {
            abort(404);
        }
        $nextPost = Blog::where('created_at', '<', $blog->created_at)->latest()->first();
        $prevPost = Blog::where('created_at', '>', $blog->created_at)->oldest()->first();
        $metaTitle = $blog->meta_title ?? 'Блог';
        $metaDescription = $blog->meta_description ?? 'Описание поста блога';

        return view('elitvid.site.blog.blog_post', compact('blog', 'metaTitle', 'metaDescription', 'nextPost', 'prevPost'));
    }

    function small_architectural_forms()
    {
        $gallery = Gallery::query()->with(['gallery_images'])->latest()->get();
        $small_architectural_forms_images = $gallery->where('type', 'maf');
        $metaTags = MetaTag::where('page', 'small_architectural_forms')->get();
        $metaTitle = $metaTags->isNotEmpty() ? $metaTags[0]->title : 'Малые архитектурные формы';
        $metaDescription = $metaTags->isNotEmpty() ? $metaTags[0]->description : 'Описание малых архитектурных форм';
        $categories = Category::where('page', 'small_architectural_forms')->get();
        $category = $categories->isNotEmpty() ? $categories[0]->description : null;
        $static_images = StaticImages::where('page', 'small_architectural_forms')->get();
        $static_images_arr = [];
        foreach ($static_images as $static_image) {
            $static_images_arr[$static_image->image] = $static_image->description_image;
        }
        try {
            $staticPage = StaticPage::where('page', 'small_architectural_forms')->first();
        } catch (\Exception $e) {
            $staticPage = null;
        }
        return view('elitvid.site.small_architectural_forms', compact('small_architectural_forms_images', 'metaTitle', 'metaDescription', 'category', 'static_images_arr', 'staticPage'));
    }
}
