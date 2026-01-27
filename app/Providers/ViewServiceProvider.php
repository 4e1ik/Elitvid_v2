<?php

namespace App\Providers;

use App\Models\StaticPage;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        view()->composer('layouts.elitvid.elitvid', function ($view) {
            $view->with([
                'metaTitle' => 'Изделия из полистоуна от производителя на заказ - Elitvid.com',
                'metaDescription' => 'Качественные изделия из полистоуна от производителя Elitvid.com.
                                        В нашем каталоге широкий выбор декоративных элементов для интерьера и экстерьера.
                                        Надежность, эстетика и доступные цены – только у нас!',
                'static_pages' => StaticPage::all(),
            ]);
        });
    }
}
