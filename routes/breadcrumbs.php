<?php

use Tabuna\Breadcrumbs\Breadcrumbs;
use Tabuna\Breadcrumbs\Trail;
//use \App\Providers\BreadcrumbsServiceProvider;

Breadcrumbs::for('home', fn (Trail $trail) =>
    $trail->push('Главная', route('home'))
);

Breadcrumbs::for('directions', fn (Trail $trail) =>
    $trail->parent('home')->push('Наши направления', route('directions'))
);

Breadcrumbs::for('benches', fn (Trail $trail) =>
    $trail->parent('directions')->push('Скамьи', route('benches'))
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

Breadcrumbs::for('directions', fn (Trail $trail) =>
    $trail->parent('home')->push('Наши направления', route('directions'))
);
