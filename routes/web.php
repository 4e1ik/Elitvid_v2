<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\MailController;
use App\Http\Controllers\Admin\MetaTagController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\StaticImagesController;
use App\Http\Controllers\StaticPagesController;
use App\Http\Controllers\Admin\StaticPageController as AdminStaticPageController;
use \App\Http\Controllers\Admin\PotController as AdminPotController;
use \App\Http\Controllers\Admin\BenchController as AdminBenchController;


use App\Http\Controllers\BenchController;
use App\Http\Controllers\BollardsAndFencingController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PotController;
use App\Http\Controllers\SitemapController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [MainController::class, 'index'])->name('home');
//Route::get('/test', [MainController::class, 'test'])->name('test');
Route::get('/thank_you', function (Request $request){
    return view('includes.elitvid.thank_you', [
        'referrer' => $request->query('referrer', '/')
    ]);
})->name('thank-you');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('index');

Route::get('/decorations', [MainController::class, 'decorations'])->name('decorations');

Route::prefix('blog')->group(function () {
    Route::get('/', [MainController::class, 'blog_posts'])->name('blog_posts');
    Route::get('/post/{id}', [MainController::class, 'show_blog_post'])->name('show_blog_post');
});

Route::prefix('directions')->group(function () {
    Route::get('/', [MainController::class, 'directions'])->name('directions');
    Route::get('/bollards_and_fencing', [BollardsAndFencingController::class, 'bollards_and_fencing'])->name('bollards_and_fencing');

    Route::prefix('benches')->group(function () {
        Route::get('/', [BenchController::class, 'benches'])->name('benches');
        Route::get('/{collection}/{id}', [BenchController::class, 'show_bench_product'])->name('show_bench_product');

        Route::prefix('verona_benches')->group(function () {
            Route::get('/', [BenchController::class, 'verona_benches'])->name('verona_benches');
        });

        Route::prefix('street_furniture_benches')->group(function () {
            Route::get('/', [BenchController::class, 'street_furniture_benches'])->name('street_furniture_benches');
        });

        Route::prefix('solo_benches')->group(function () {
            Route::get('/', [BenchController::class, 'solo_benches'])->name('solo_benches');
        });

        Route::prefix('lines_benches')->group(function () {
            Route::get('/', [BenchController::class, 'lines_benches'])->name('lines_benches');
        });

        Route::prefix('stones_benches')->group(function () {
            Route::get('/', [BenchController::class, 'stones_benches'])->name('stones_benches');

        });
    });

    Route::prefix('pots')->group(function () {
        Route::get('/', [PotController::class, 'pots'])->name('pots');
        Route::get('/{collection}/{id}', [PotController::class, 'show_pot_product'])->name('show_pot_product');

        Route::prefix('rectangular_pots')->group(function () {
            Route::get('/', [PotController::class, 'rectangular_pots'])->name('rectangular_pots');
        });
        Route::prefix('square_pots')->group(function () {
            Route::get('/', [PotController::class, 'square_pots'])->name('square_pots');
        });
        Route::prefix('round_pots')->group(function () {
            Route::get('/', [PotController::class, 'round_pots'])->name('round_pots');
        });
    });

    Route::get('/{slug}', [StaticPagesController::class, 'index'])->name('static_page');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/registration', [RegisterController::class, 'index'])->name('registration');
Route::post('/registration', [RegisterController::class, 'registration'])->name('save');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/send_mail', [MailController::class, 'send'])->name('send_mail');



Route::middleware('auth')->where([])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');

    // Скамейки в панели администратора
    Route::prefix('benches')->group(function (){
        Route::get('/benches_verona', [AdminBenchController::class, 'verona'])->name('admin_benches_verona');
        Route::get('/benches_stones', [AdminBenchController::class, 'stones'])->name('admin_benches_stones');
        Route::get('/benches_solo', [AdminBenchController::class, 'solo'])->name('admin_benches_solo');
        Route::get('/benches_lines', [AdminBenchController::class, 'lines'])->name('admin_benches_lines');
        Route::get('/benches_street_furniture', [AdminBenchController::class, 'street_furniture'])->name('admin_benches_street_furniture');
    });

    // Кашпо в панели администратора
    Route::prefix('pots')->group(function (){
        Route::get('/round_pots', [AdminPotController::class, 'round_pots'])->name('admin_round_pots');
        Route::get('/rectangular_pots', [AdminPotController::class, 'rectangular_pots'])->name('admin_rectangular_pots');
        Route::get('/square_pots', [AdminPotController::class, 'square_pots'])->name('admin_square_pots');
    });

    // Примеры работ в панели администратора

    /*
     * Статические картинки сайта
     */
    Route::prefix('static_images')->group(function (){
        Route::get('/{page}', [AdminController::class, 'static_images'])->name('admin_static_images');
    });

    //Блог в панели администратора
    Route::prefix('blog')->group(function () {
        Route::get('/', [AdminController::class, 'blog_posts'])->name('admin_blog');
    });

    Route::get('/create/{route}', [AdminController::class, 'create'])->name('create');

    // Изображения (полиморфная структура)
    Route::put('/images/{image}/update', [\App\Http\Controllers\Admin\ImageController::class, 'update'])->name('images.update');
    Route::delete('/images/{image}/delete', [\App\Http\Controllers\Admin\ImageController::class, 'destroy'])->name('images.destroy');

    //Контент страниц (объединенный: мета-теги, категории, галереи)
    Route::get('/page-contents', [\App\Http\Controllers\Admin\PageContentController::class, 'index'])->name('admin_page_contents.index');
    Route::get('/page-contents/{page}/edit', [\App\Http\Controllers\Admin\PageContentController::class, 'edit'])->name('admin_page_contents.edit');
    Route::put('/page-contents/{page}', [\App\Http\Controllers\Admin\PageContentController::class, 'update'])->name('admin_page_contents.update');
    Route::put('/page-contents/{page}/images/{imageId}/description', [\App\Http\Controllers\Admin\PageContentController::class, 'updateImageDescription'])->name('admin_page_contents.update_image_description');

    Route::resources([
        'galleries' => GalleryController::class,
        'blogs' => BlogController::class,
        'static_images' => StaticImagesController::class,
        'static_pages' => AdminStaticPageController::class,
        'products' => ProductController::class,
    ]);
});
