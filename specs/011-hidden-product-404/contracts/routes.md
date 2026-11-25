# Contract: страницы товара

| Маршрут | Имя | Активный товар | Скрытый товар | Нет товара |
|---|---|---|---|---|
| `GET /napravleniya/skami/{collection}/{slug}` | `show_bench_product` | 200 | 404 | 404 |
| `GET /napravleniya/kashpo/{collection}/{slug}` | `show_pot_product` | 200 | 404 | 404 |
| `GET /napravleniya/urny/{slug}` | `show_urn_product` | 200 | 404 | 404 |

Одинаково для гостя и для вошедшего пользователя админки.
