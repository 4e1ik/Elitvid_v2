<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PotImageController;
use App\Http\Controllers\BenchImageController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PotProductController;
use App\Http\Controllers\BenchProductController;
use \App\Http\Controllers\MailController;
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

Route::get('/decorations', [MainController::class, 'decorations'])->name('decorations');

Route::prefix('directions')->group(function () {
    Route::get('/', [MainController::class, 'directions'])->name('directions');

    Route::get('/bollards_and_fencing', [MainController::class, 'bollards_and_fencing'])->name('bollards_and_fencing');
    Route::get('/facade_stucco_molding_and_panels', [MainController::class, 'facade_stucco_molding_and_panels'])->name('facade_stucco_molding_and_panels');
    Route::get('/parklets_and_canopies', [MainController::class, 'parklets_and_canopies'])->name('parklets_and_canopies');
    Route::get('/pillars_and_covers', [MainController::class, 'pillars_and_covers'])->name('pillars_and_covers');
    Route::get('/rotundas_and_colonnades', [MainController::class, 'rotundas_and_colonnades'])->name('rotundas_and_colonnades');

    Route::prefix('benches')->group(function () {
        Route::get('/', [MainController::class, 'benches'])->name('benches');

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

Route::post('/send_mail', [MailController::class, 'send'])->name('send_mail');
//Route::post('/orderCall', [MailController::class, 'order_call'])->name('order_call');


Route::middleware('auth')->where([])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    Route::get('/benches', [AdminController::class, 'benches'])->name('admin_benches');
    Route::get('/pots', [AdminController::class, 'pots'])->name('admin_pots');
    Route::get('/gallery', [AdminController::class, 'gallery'])->name('admin_gallery');

    Route::get('/create/{route}', [AdminController::class, 'create'])->name('create');

    // Кашпо
    Route::delete('/pot/images/{potImage}/{potProduct}/delete', [PotImageController::class, 'pot_image_destroy'])->name('pot_image_destroy');
    Route::put('/pot/images/{potImage}/{potProduct}/update', [PotImageController::class, 'pot_image_update'])->name('pot_image_update');

    // Скамейки
    Route::delete('/bench/images/{benchImage}/{benchProduct}/delete', [BenchImageController::class, 'bench_image_destroy'])->name('bench_image_destroy');
    Route::put('/bench/images/{benchImage}/{benchProduct}/update', [BenchImageController::class, 'bench_image_update'])->name('bench_image_update');

    Route::resources([
        'potProducts' => PotProductController::class,
        'benchProducts' => BenchProductController::class,
        'galleries' => GalleryController::class,
    ]);
});
