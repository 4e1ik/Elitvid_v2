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
            $data = $view->getData();
            $view->with([
                // Передаем дефолт только если контроллер не передал значение
                'metaTitle' => $data['metaTitle'] ?? 'Изделия из полистоуна от производителя на заказ - Elitvid.com',
                'metaDescription' => $data['metaDescription'] ?? 'Качественные изделия из полистоуна от производителя Elitvid.com.
                                    В нашем каталоге широкий выбор декоративных элементов для интерьера и экстерьера.
                                    Надежность, эстетика и доступные цены – только у нас!',
                'static_pages' => $data['static_pages'] ?? StaticPage::where('active', 1)->get(),
            ]);
        });
    }
}
