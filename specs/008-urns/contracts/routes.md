# Contracts: маршруты

| Метод | Адрес | Имя | Доступ |
|---|---|---|---|
| GET | `/napravleniya/urny` | `urns` | все |
| GET | `/napravleniya/urny/{slug}` | `show_urn_product` | все; slug не урны → 404 |
| GET | `/admin/urns` | `admin_urns` | `admin`, `manager`, `viewer` |
| GET | `/admin/create/urns` | `create` (есть) | `admin`, `manager`, `viewer` |
| POST/PUT/DELETE | `products.*` (есть) | — | как сейчас; `product_type=urn` |
| POST | `/cart/items` (есть) | `cart.add` | `product_id` урны принимается |

Маршрут `show_urn_product` объявляется до `/{slug}` статических страниц внутри `napravleniya`.
