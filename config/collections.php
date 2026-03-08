<?php

return [
    /*
    | Соответствие коллекции скамеек (из БД) сегменту URL в web.php.
    | Маршруты: napravleniya/skami/{segment}/ и napravleniya/skami/{segment}/{slug}
    */
    'bench_url_segments' => [
        'Verona' => 'verona',
        'Stones' => 'stones',
        'Solo' => 'solo',
        'lines' => 'lines',
        'Street_furniture' => 'street-furniture',
    ],

    /*
    | Соответствие коллекции кашпо (из БД) сегменту URL в web.php.
    | Маршруты: napravleniya/kashpo/{segment}/ и napravleniya/kashpo/{segment}/{slug}
    */
    'pot_url_segments' => [
        'Round' => 'kruglye',
        'Square' => 'kvadratnye',
        'Rectangular' => 'pryamougolnye',
    ],
];
