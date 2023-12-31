<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TexturesController;
use App\Http\Controllers\GalleryController;
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
Route::get('/about', [MainController::class, 'about'])->name('about');
Route::get('/benches', [MainController::class, 'benches'])->name('benches');
Route::get('/catalog', [MainController::class, 'catalog'])->name('catalog');

Route::prefix('pots')->group(function () {
    Route::get('/', [MainController::class, 'pots'])->name('pots');
    Route::get('/rectangular_pots', [MainController::class, 'rectangular_pots'])->name('rectangular_pots');
    Route::get('/square_pots', [MainController::class, 'square_pots'])->name('square_pots');
    Route::get('/round_pots', [MainController::class, 'round_pots'])->name('round_pots');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

//Закомментировано для production.
Route::get('/registration', [RegisterController::class, 'index'])->name('registration');
Route::post('/registration', [RegisterController::class, 'registration'])->name('save');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/form', [MailController::class, 'show_form'])->name('form');
Route::post('/sendForm', [MailController::class, 'send'])->name('send_mail');

Route::get('/product/{id}', [MainController::class, 'show_product'])->name('show_product');


Route::middleware('auth')->where([

])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    Route::get('/catalog', [AdminController::class, 'catalog'])->name('admin_catalog');
    Route::get('/benches', [AdminController::class, 'benches'])->name('admin_benches');
    Route::get('/pots', [AdminController::class, 'pots'])->name('admin_pots');
    Route::get('/texture', [AdminController::class, 'textures'])->name('admin_textures');
    Route::get('/gallery', [AdminController::class, 'gallery'])->name('admin_gallery');

    Route::get('/create/{route}', [AdminController::class, 'create'])->name('create');

    Route::delete('/gallery/images/{image}/{product}/delete', [ImageController::class, 'destroy'])->name('image_destroy');
    Route::put('/gallery/images/{image}/{product}/update', [ImageController::class, 'update'])->name('image_update');

    Route::delete('/images/{image}/{gallery}/delete', [ImageController::class, 'gallery_image_destroy'])->name('gallery_image_destroy');
    Route::put('/images/{image}/update', [ImageController::class, 'gallery_image_update'])->name('gallery_image_update');

    Route::delete('/textures/images/{image}/{texture}/delete', [ImageController::class, 'texture_image_destroy'])->name('texture_image_destroy');
    Route::put('/textures/images/{image}/{texture}/update', [ImageController::class, 'texture_image_update'])->name('texture_image_update');

//    Route::post('/images', [ImageController::class, 'store'])->name('image_create');

    Route::resources([
        'products' =>  ProductController::class,
        'textures' =>  TexturesController::class,
        'galleries' => GalleryController::class,
    ]);
});
