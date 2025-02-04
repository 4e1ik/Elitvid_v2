<?php

use App\Models\BenchProduct;
use App\Models\Blog;
use App\Models\PotProduct;
use Tabuna\Breadcrumbs\Breadcrumbs;
use Tabuna\Breadcrumbs\Trail;
//use \App\Providers\BreadcrumbsServiceProvider;

Breadcrumbs::for('home', fn (Trail $trail) =>
    $trail->push('Главная', route('home'))
);

Breadcrumbs::for('directions', fn (Trail $trail) =>
    $trail->parent('home')->push('Наши направления', route('directions'))
);

Breadcrumbs::for('decorations', fn (Trail $trail) =>
$trail->parent('home')->push('Декоративные элементы', route('decorations'))
);

Breadcrumbs::for('bollards_and_fencing', fn (Trail $trail) =>
$trail->parent('directions')->push('Болларды и ограждения', route('bollards_and_fencing'))
);

Breadcrumbs::for('facade_stucco_molding_and_panels', fn (Trail $trail) =>
$trail->parent('directions')->push('Фасадная лепнина и панели', route('facade_stucco_molding_and_panels'))
);

Breadcrumbs::for('parklets_and_canopies', fn (Trail $trail) =>
$trail->parent('directions')->push('Парклеты, навесы', route('parklets_and_canopies'))
);

Breadcrumbs::for('pillars_and_covers', fn (Trail $trail) =>
$trail->parent('directions')->push('Парклеты, навесы', route('pillars_and_covers'))
);

Breadcrumbs::for('rotundas_and_colonnades', fn (Trail $trail) =>
$trail->parent('directions')->push('Ротонды и коллонады', route('rotundas_and_colonnades'))
);

Breadcrumbs::for('benches', fn (Trail $trail) =>
$trail->parent('directions')->push('Скамьи', route('benches'))
);

Breadcrumbs::for('verona_benches', fn (Trail $trail) =>
$trail->parent('benches')->push('Коллекция Verona', route('verona_benches'))
);

Breadcrumbs::for('street_furniture_benches', fn (Trail $trail) =>
$trail->parent('benches')->push('Коллекция Street Furniture', route('street_furniture_benches'))
);

Breadcrumbs::for('solo_benches', fn (Trail $trail) =>
$trail->parent('benches')->push('Коллекция Solo', route('solo_benches'))
);

Breadcrumbs::for('lines_benches', fn (Trail $trail) =>
$trail->parent('benches')->push('Коллекция Lines', route('lines_benches'))
);

Breadcrumbs::for('stones_benches', fn (Trail $trail) =>
$trail->parent('benches')->push('Коллекция Stones', route('stones_benches'))
);

Breadcrumbs::for('blog_posts', fn (Trail $trail) =>
$trail->parent('home')->push('Новости', route('blog_posts'))
);

Breadcrumbs::for('show_blog_post', fn (Trail $trail, $id) =>
$trail->parent('blog_posts')->push(Blog::where('id', $id)->get()[0]['title'], route('show_blog_post', $id))
);

Breadcrumbs::for('show_bench_product', fn (Trail $trail, $id) =>
$trail->parent(Route::getRoutes()->match(request()->create(url()->previousPath()))->getName() == 'verona_benches' ? 'verona_benches' :
        (Route::getRoutes()->match(request()->create(url()->previousPath()))->getName() == 'street_furniture_benches' ? 'street_furniture_benches' :
        (Route::getRoutes()->match(request()->create(url()->previousPath()))->getName() == 'solo_benches' ? 'solo_benches' :
        (Route::getRoutes()->match(request()->create(url()->previousPath()))->getName() == 'lines_benches' ? 'lines_benches' :
        (Route::getRoutes()->match(request()->create(url()->previousPath()))->getName() == 'stones_benches' ? 'stones_benches' : 'benches'))))
)->push(BenchProduct::query()->with('bench_images')->where('id', $id)->get()[0]['name'], route('show_bench_product', $id))
);


Breadcrumbs::for('pots', fn (Trail $trail) =>
    $trail->parent('directions')->push('Кашпо', route('pots'))
);

Breadcrumbs::for('rectangular_pots', fn (Trail $trail) =>
    $trail->parent('pots')->push('Прямоугольные кашпо', route('rectangular_pots'))
);

Breadcrumbs::for('square_pots', fn (Trail $trail) =>
    $trail->parent('pots')->push('Квадратные кашпо', route('square_pots'))
);

Breadcrumbs::for('round_pots', fn (Trail $trail) =>
    $trail->parent('pots')->push('Круглые кашпо', route('round_pots'))
);



Breadcrumbs::for('show_pot_product', fn (Trail $trail, $id) =>
$trail->parent(Route::getRoutes()->match(request()->create(url()->previousPath()))->getName() == 'round_pots' ? 'round_pots' :
                    (Route::getRoutes()->match(request()->create(url()->previousPath()))->getName() == 'square_pots' ? 'square_pots' :
                    (Route::getRoutes()->match(request()->create(url()->previousPath()))->getName() == 'rectangular_pots' ? 'rectangular_pots' : 'pots'))
                )->push(PotProduct::query()->with('pot_images')->where('id', $id)->get()[0]['name'], route('show_pot_product', $id))
);
