<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BenchController as AdminBenchController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\PageContentController;
use App\Http\Controllers\Admin\PotController as AdminPotController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\StaticImagesController;
use App\Http\Controllers\Admin\StaticPageController;
use App\Http\Controllers\BenchController;
use App\Http\Controllers\BollardsAndFencingController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\Admin\MailController as AdminMailController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PotController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\StaticPagesController;
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

Route::get('/dekorativnye-elementy-polistouna', [MainController::class, 'decorations'])->name('decorations');

Route::prefix('blog')->group(function () {
    Route::get('/', [MainController::class, 'blog_posts'])->name('blog_posts');
    Route::get('/post/{slug}', [MainController::class, 'show_blog_post'])->name('show_blog_post');
});

Route::prefix('napravleniya')->group(function () {
    Route::get('/', [MainController::class, 'directions'])->name('directions');
    Route::get('/bollardy-ograzhdeniya', [BollardsAndFencingController::class, 'bollards_and_fencing'])->name('bollards_and_fencing');

    Route::prefix('skami')->group(function () {
        Route::get('/', [BenchController::class, 'benches'])->name('benches');
        Route::get('/{collection}/{slug}', [BenchController::class, 'show_bench_product'])->name('show_bench_product');

        Route::prefix('verona')->group(function () {
            Route::get('/', [BenchController::class, 'verona_benches'])->name('verona_benches');
        });

        Route::prefix('street-furniture')->group(function () {
            Route::get('/', [BenchController::class, 'street_furniture_benches'])->name('street_furniture_benches');
        });

        Route::prefix('solo')->group(function () {
            Route::get('/', [BenchController::class, 'solo_benches'])->name('solo_benches');
        });

        Route::prefix('lines')->group(function () {
            Route::get('/', [BenchController::class, 'lines_benches'])->name('lines_benches');
        });

        Route::prefix('stones')->group(function () {
            Route::get('/', [BenchController::class, 'stones_benches'])->name('stones_benches');
        });
    });

    Route::prefix('kashpo')->group(function () {
        Route::get('/', [PotController::class, 'pots'])->name('pots');
        Route::get('/{collection}/{slug}', [PotController::class, 'show_pot_product'])->name('show_pot_product');

        Route::prefix('pryamougolnye')->group(function () {
            Route::get('/', [PotController::class, 'rectangular_pots'])->name('rectangular_pots');
        });
        Route::prefix('kvadratnye')->group(function () {
            Route::get('/', [PotController::class, 'square_pots'])->name('square_pots');
        });
        Route::prefix('kruglye')->group(function () {
            Route::get('/', [PotController::class, 'round_pots'])->name('round_pots');
        });
    });

    Route::get('/{slug}', [StaticPagesController::class, 'index'])->name('static_page');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/send_mail', [MailController::class, 'send'])->name('send_mail');



Route::middleware(['auth', 'role.access:admin,manager,viewer'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');

    Route::prefix('benches')->group(function () {
        Route::get('/benches_verona', [AdminBenchController::class, 'verona'])->name('admin_benches_verona');
        Route::get('/benches_stones', [AdminBenchController::class, 'stones'])->name('admin_benches_stones');
        Route::get('/benches_solo', [AdminBenchController::class, 'solo'])->name('admin_benches_solo');
        Route::get('/benches_lines', [AdminBenchController::class, 'lines'])->name('admin_benches_lines');
        Route::get('/benches_street_furniture', [AdminBenchController::class, 'street_furniture'])->name('admin_benches_street_furniture');
    });

    Route::prefix('pots')->group(function () {
        Route::get('/round_pots', [AdminPotController::class, 'round_pots'])->name('admin_round_pots');
        Route::get('/rectangular_pots', [AdminPotController::class, 'rectangular_pots'])->name('admin_rectangular_pots');
        Route::get('/square_pots', [AdminPotController::class, 'square_pots'])->name('admin_square_pots');
    });

    Route::prefix('static_images')->group(function () {
        Route::get('/{page}', [AdminController::class, 'static_images'])->name('admin_static_images');
    });

    Route::prefix('blog')->group(function () {
        Route::get('/', [BlogController::class, 'index'])->name('admin_blog');
    });

    Route::get('/create/{route}', [AdminController::class, 'create'])->name('create');

    Route::get('/page-contents', [PageContentController::class, 'index'])->name('admin_page_contents.index');
    Route::get('/page-contents/{pageContent}/edit', [PageContentController::class, 'edit'])->name('admin_page_contents.edit');

    Route::get('/mails', [AdminMailController::class, 'index'])
        ->middleware('role.access:admin,manager')
        ->name('admin_mails.index');

    Route::middleware('role.access:admin')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
    });

    Route::resource('blogs', BlogController::class)->only(['index', 'create', 'edit', 'show']);
    Route::resource('static_pages', StaticPageController::class)->only(['index', 'create', 'edit', 'show']);
    Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');

    Route::middleware('deny.roles:viewer')->group(function () {
        Route::put('/images/{image}/update', [\App\Http\Controllers\Admin\ImageController::class, 'update'])->name('images.update');
        Route::put('/page-contents/{pageContent}', [PageContentController::class, 'update'])->name('admin_page_contents.update');
        Route::put('/static_images/{static_image}/update', [StaticImagesController::class, 'update'])->name('static_images.update');

        Route::resource('blogs', BlogController::class)->only(['store', 'update']);
        Route::resource('static_pages', StaticPageController::class)->only(['store', 'update']);
        Route::post('products', [ProductController::class, 'store'])->name('products.store');
        Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
    });

    Route::middleware('role.access:admin')->group(function () {
        Route::delete('/images/{image}/delete', [\App\Http\Controllers\Admin\ImageController::class, 'destroy'])->name('images.destroy');
        Route::delete('blogs/{blog}', [BlogController::class, 'destroy'])->name('blogs.destroy');
        Route::delete('static_pages/{static_page}', [StaticPageController::class, 'destroy'])->name('static_pages.destroy');
        Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    });
});
