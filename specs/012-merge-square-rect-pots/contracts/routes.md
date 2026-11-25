# Contract: HTTP-адреса

Префикс сайта — `/napravleniya/kashpo`.

## Сайт

| Метод | Адрес | Имя маршрута | Ответ |
|---|---|---|---|
| GET | `/kvadratnye-i-pryamougolnye` | `square_rectangular_pots` | 200, страница «Квадратные и прямоугольные кашпо» |
| GET | `/kvadratnye-i-pryamougolnye/{slug}` | `show_pot_product` (общий `/{collection}/{slug}`) | 200 для активного товара, 404 для скрытого |
| GET | `/kvadratnye` | — | 301 → `/napravleniya/kashpo/kvadratnye-i-pryamougolnye` |
| GET | `/pryamougolnye` | — | 301 → `/napravleniya/kashpo/kvadratnye-i-pryamougolnye` |
| GET | `/kvadratnye/{slug}` | — | 301 → `/napravleniya/kashpo/kvadratnye-i-pryamougolnye/{slug}` |
| GET | `/pryamougolnye/{slug}` | — | 301 → `/napravleniya/kashpo/kvadratnye-i-pryamougolnye/{slug}` |

Маршруты `square_pots` и `rectangular_pots` удаляются.

## Админка (`/admin/pots`, middleware без изменений)

| Метод | Адрес | Имя маршрута |
|---|---|---|
| GET | `/square_rectangular_pots` | `admin_square_rectangular_pots` |

Маршруты `admin_square_pots` и `admin_rectangular_pots` удаляются. Картинки страницы: `admin_static_images` с `page=square_rectangular_pots`.

## Sitemap

Есть: `/napravleniya/kashpo/kvadratnye-i-pryamougolnye` и товары `/napravleniya/kashpo/kvadratnye-i-pryamougolnye/{slug}`. Нет: `/kvadratnye`, `/pryamougolnye` и товаров с этими сегментами.
