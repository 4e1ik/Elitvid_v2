<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PotImageController;
use App\Http\Controllers\BenchImageController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PotProductController;
use App\Http\Controllers\BenchProductController;
use App\Http\Controllers\ProductController;
//use App\Http\Controllers\TexturesController;
//use App\Http\Controllers\GalleryController;
use \App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Route;
//use Tabuna\Breadcrumbs\Trail;

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
//Route::get('/test', function (){
//    $a = 1;
//    return  $a;
//});

Route::get('/decorations', [MainController::class, 'decorations'])->name('decorations');

Route::prefix('directions')->group(function () {
    Route::get('/', [MainController::class, 'directions'])->name('directions');

    Route::prefix('benches')->group(function () {
        Route::get('/', [MainController::class, 'benches'])->name('benches');


//        Route::prefix('verona_benches')->group(function () {
//            Route::get('/', [MainController::class, 'verona_benches'])->name('verona_benches');
//            Route::get('/{id}', [MainController::class, 'show_bench_product'])->name('show_bench_product');
//        });

        Route::prefix('verona_benches')->group(function () {
            Route::get('/', [MainController::class, 'verona_benches'])->name('verona_benches');
            Route::get('/{id}', [MainController::class, 'show_bench_product'])->name('show_bench_product');
        });

        Route::prefix('street_furniture_benches')->group(function () {
            Route::get('/', [MainController::class, 'street_furniture_benches'])->name('street_furniture_benches');
            Route::get('/{id}', [MainController::class, 'show_bench_product'])->name('show_bench_product');
        });

        Route::prefix('solo_benches')->group(function () {
            Route::get('/', [MainController::class, 'solo_benches'])->name('solo_benches');
            Route::get('/{id}', [MainController::class, 'show_bench_product'])->name('show_bench_product');
        });

        Route::prefix('lines_benches')->group(function () {
            Route::get('/', [MainController::class, 'lines_benches'])->name('lines_benches');
            Route::get('/{id}', [MainController::class, 'show_bench_product'])->name('show_bench_product');
        });

        Route::prefix('stones_benches')->group(function () {
            Route::get('/', [MainController::class, 'stones_benches'])->name('stones_benches');
            Route::get('/{id}', [MainController::class, 'show_bench_product'])->name('show_bench_product');
        });
//        Route::prefix('square_pots')->group(function () {
//            Route::get('/', [MainController::class, 'square_pots'])->name('square_pots');
//            Route::get('/{id}', [MainController::class, 'show_bench_product'])->name('show_bench_product');
//        });
//        Route::prefix('round_pots')->group(function () {
//            Route::get('/', [MainController::class, 'round_pots'])->name('round_pots');
//            Route::get('/{id}', [MainController::class, 'show_bench_product'])->name('show_bench_product');
//        });
    });

    Route::prefix('pots')->group(function () {
        Route::get('/', [MainController::class, 'pots'])->name('pots');


        Route::prefix('rectangular_pots')->group(function () {
            Route::get('/', [MainController::class, 'rectangular_pots'])->name('rectangular_pots');
            Route::get('/{id}', [MainController::class, 'show_pot_product'])->name('show_pot_product');
        });
        Route::prefix('square_pots')->group(function () {
            Route::get('/', [MainController::class, 'square_pots'])->name('square_pots');
            Route::get('/{id}', [MainController::class, 'show_pot_product'])->name('show_pot_product');
        });
        Route::prefix('round_pots')->group(function () {
            Route::get('/', [MainController::class, 'round_pots'])->name('round_pots');
            Route::get('/{id}', [MainController::class, 'show_pot_product'])->name('show_pot_product');
        });
    });
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/registration', [RegisterController::class, 'index'])->name('registration');
Route::post('/registration', [RegisterController::class, 'registration'])->name('save');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

//Route::get('/form', [MailController::class, 'show_form'])->name('form');
Route::post('/', [MailController::class, 'send'])->name('send_mail');
//Route::post('/orderCall', [MailController::class, 'order_call'])->name('order_call');




Route::middleware('auth')->where([])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    Route::get('/catalog', [AdminController::class, 'catalog'])->name('admin_catalog');
    Route::get('/benches', [AdminController::class, 'benches'])->name('admin_benches');
    Route::get('/pots', [AdminController::class, 'pots'])->name('admin_pots');
    Route::get('/texture', [AdminController::class, 'textures'])->name('admin_textures');
    Route::get('/gallery', [AdminController::class, 'gallery'])->name('admin_gallery');

    Route::get('/create/{route}', [AdminController::class, 'create'])->name('create');

    // Кашпо
    Route::delete('/pot/images/{potImage}/{potProduct}/delete', [PotImageController::class, 'pot_image_destroy'])->name('pot_image_destroy');
    Route::put('/pot/images/{potImage}/{potProduct}/update', [PotImageController::class, 'pot_image_update'])->name('pot_image_update');

    // Кашпо
    Route::delete('/bench/images/{benchImage}/{benchProduct}/delete', [BenchImageController::class, 'bench_image_destroy'])->name('bench_image_destroy');
    Route::put('/bench/images/{benchImage}/{benchProduct}/update', [BenchImageController::class, 'bench_image_update'])->name('bench_image_update');

//    Route::delete('/images/{image}/{gallery}/delete', [ImageController::class, 'gallery_image_destroy'])->name('gallery_image_destroy');
//    Route::put('/images/{image}/update', [ImageController::class, 'gallery_image_update'])->name('gallery_image_update');


//    Route::delete('/textures/images/{image}/{texture}/delete', [ImageController::class, 'texture_image_destroy'])->name('texture_image_destroy');
//    Route::put('/textures/images/{image}/{texture}/update', [ImageController::class, 'texture_image_update'])->name('texture_image_update');

//    Route::post('/images', [ImageController::class, 'store'])->name('image_create');

    Route::resources([
        'potProducts' => PotProductController::class,
        'benchProducts' => BenchProductController::class,
//        'textures' => TexturesController::class,
//        'galleries' => GalleryController::class,
    ]);
});
