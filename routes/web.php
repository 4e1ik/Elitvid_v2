<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BenchController as AdminBenchController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\PageContentController;
use App\Http\Controllers\Admin\PotController as AdminPotController;
use App\Http\Controllers\Admin\UrnController as AdminUrnController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\StaticImagesController;
use App\Http\Controllers\Admin\StaticPageController;
use App\Http\Controllers\BenchController;
use App\Http\Controllers\BollardsAndFencingController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\MailAttachmentController;
use App\Http\Controllers\Admin\MailController as AdminMailController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PotController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\StaticPagesController;
use App\Http\Controllers\UrnController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by bootstrap/app.php with the "web" middleware group.
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
        // коллекцию Street furniture убрали (спека 006): старые адреса — постоянные перенаправления
        Route::permanentRedirect('/street-furniture', '/napravleniya/skami')->name('street_furniture_benches');
        Route::get('/street-furniture/{slug}', [BenchController::class, 'street_furniture_product'])->name('street_furniture_product');
        Route::get('/{collection}/{slug}', [BenchController::class, 'show_bench_product'])->name('show_bench_product');

        Route::prefix('verona')->group(function () {
            Route::get('/', [BenchController::class, 'verona_benches'])->name('verona_benches');
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
        // квадратные и прямоугольные объединены (спека 012): старые адреса — постоянные перенаправления
        Route::permanentRedirect('/kvadratnye', '/napravleniya/kashpo/kvadratnye-i-pryamougolnye');
        Route::permanentRedirect('/pryamougolnye', '/napravleniya/kashpo/kvadratnye-i-pryamougolnye');
        Route::permanentRedirect('/kvadratnye/{slug}', '/napravleniya/kashpo/kvadratnye-i-pryamougolnye/{slug}');
        Route::permanentRedirect('/pryamougolnye/{slug}', '/napravleniya/kashpo/kvadratnye-i-pryamougolnye/{slug}');
        Route::get('/kvadratnye-i-pryamougolnye', [PotController::class, 'square_rectangular_pots'])->name('square_rectangular_pots');
        Route::get('/{collection}/{slug}', [PotController::class, 'show_pot_product'])->name('show_pot_product');

        Route::prefix('kruglye')->group(function () {
            Route::get('/', [PotController::class, 'round_pots'])->name('round_pots');
        });
    });

    Route::prefix('urny')->group(function () {
        Route::get('/', [UrnController::class, 'urns'])->name('urns');
        Route::get('/{slug}', [UrnController::class, 'show_urn_product'])->name('show_urn_product');
    });

    Route::get('/sbornye-klumby', [MainController::class, 'flowerbeds'])->name('flowerbeds');
    Route::get('/{slug}', [StaticPagesController::class, 'index'])->name('static_page');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/send_mail', [MailController::class, 'send'])->name('send_mail');

Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
Route::post('/cart/items', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/items/{product}', [CartController::class, 'update'])->whereNumber('product')->name('cart.update');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/cart/order', [CartController::class, 'place'])->name('cart.place');

Route::get('/storage/files/{filename}', [MailAttachmentController::class, 'show'])
    ->where('filename', '[^/]+')
    ->name('mail_attachment.show');

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
        Route::get('/square_rectangular_pots', [AdminPotController::class, 'square_rectangular_pots'])->name('admin_square_rectangular_pots');
    });

    Route::get('/urns', [AdminUrnController::class, 'index'])->name('admin_urns');

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

    Route::middleware('role.access:admin,manager')->group(function () {
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin_orders.index');
        Route::get('/orders/export', [AdminOrderController::class, 'export'])->name('admin_orders.export');
    });

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
