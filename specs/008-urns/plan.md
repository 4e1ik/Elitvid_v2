# Implementation Plan: Урны

**Branch**: `008-urns` | **Date**: 2026-11-25 | **Spec**: [spec.md](spec.md)

## Summary

Урна — новый тип товара `urn` рядом с `pot` и `bench`: строка `products` + строка новой таблицы `urns` (материал, варианты). Без формы-коллекции. Сайт: список `/napravleniya/urny` по кадру 246-1882 на каркасе редизайна и карточка `/napravleniya/urny/{slug}` — копия карточки кашпо. Админка: раздел «Урны», создание и правка через общие `products.*` и формы кашпо, которые получают ветку для урны. Урны добавляются в корзину, sitemap, «Контент страниц». Пять урн заводятся через админку.

## Technical Context

- PHP 8.5, Laravel 13, Blade, jQuery — без новых библиотек.
- Хранилище: миграция `urns` (как `pots` без `collection`), миграция строки `page_contents.page = 'urns'` (как спека 007). Фото — общая `images` (morph на `Product`), цвет и фактура — как у кашпо.
- Фон первого экрана — `public/elitvid_assets/redesign/images/urns-hero.webp` из `~/Downloads/urni/image 89.png`.
- Тесты: новый `tests/Feature/UrnPagesTest.php` (список, карточка, корзина, 404); запуск `./vendor/bin/phpunit` — с разрешения пользователя.
- Ограничения: кашпо и скамейки не меняют поведения (FR-012); сервер принимает файл до 2 МБ — фото урн 130–280 КБ, проходят.

## Constitution Check

`.specify/memory/constitution.md` — пустой шаблон, действуют правила `AGENTS.md` (бэкенд) и `resources/views/AGENTS.md` (фронт).

- Маршруты новые, имена подтверждаются в `routes/web.php`: `urns`, `show_urn_product`, `admin_urns` — PASS.
- Чтение списков и карточки: Controller → Repository (`UrnRepository`, `Admin\UrnRepository`). Входных данных нет, поэтому Request/DTO/Service для чтения не заводятся — так же читают кашпо и скамейки (`Admin\PotRepository`, `BenchRepository`) — PASS.
- Запись идёт через существующий `ProductController` → `Create/UpdateProductRequest` → `ProductService`; добавляется ветка `urn` — новых слоёв не нужно — PASS.
- Правило «товар можно положить в корзину» живёт на бэкенде (`AddToCartRequest`, `CartService::lines`) — добавляется `urn` — PASS.
- Права ролей — существующие группы маршрутов; `admin_urns` в группе чтения — PASS.
- Повторяемые части фронта — существующие `components/elitvid/*` (`breadcrumbs`, `direction-card`, `works`, `cart-buttons`) — PASS.

## Project Structure

```text
database/migrations/2026_11_25_100000_create_urns_table.php
database/migrations/2026_11_25_100001_add_urns_page_content.php
app/Models/Urn.php                                    # новая
app/Models/Product.php                                # urn()
app/Repositories/UrnRepository.php                    # сайт: активные урны, урна по slug, другие урны
app/Repositories/Admin/UrnRepository.php              # админка: все урны
app/Http/Controllers/UrnController.php                # urns, show_urn_product
app/Http/Controllers/Admin/UrnController.php          # index
app/Http/Controllers/Admin/AdminController.php        # create('urns') → productType 'urn'
app/Http/Controllers/Admin/ProductController.php      # edit: load urn
app/Http/Requests/CreateProductRequest.php            # in:pot,bench,urn; collection не нужна урне; ≥1 фото
app/Http/Requests/UpdateProductRequest.php            # то же
app/Http/Requests/AddToCartRequest.php                # + urn
app/Services/Admin/ProductService.php                 # store/update: case urn
app/Services/CartService.php                          # + urn в доступных
app/Helpers/ProductRouteCreatingHelper.php            # urn → admin_urns
app/Http/Controllers/SitemapController.php            # urns + урны
config/pages.php                                      # 'urns' => 'Урны'
routes/web.php, routes/breadcrumbs.php
resources/views/elitvid/site/urns.blade.php           # список по кадру
resources/views/elitvid/site/urns/urn_product_page.blade.php  # копия карточки кашпо
resources/views/elitvid/admin/urns/urns.blade.php     # копия списка кашпо
resources/views/includes/elitvid/admin/create_urn_form.blade.php  # форма кашпо без «Формы»
resources/views/includes/elitvid/admin/update_urn_form.blade.php
resources/views/includes/elitvid/admin/create_product.blade.php, update_product.blade.php  # urn как pot
resources/views/layouts/elitvid/admin/admin.blade.php # пункт «Урны» (десктоп и мобильное меню)
resources/views/includes/elitvid/redesign-directions.blade.php, components/elitvid/footer.blade.php
public/elitvid_assets/redesign/redesign.css           # rd-hero--urns
public/elitvid_assets/redesign/images/urns-hero.webp
tests/Feature/UrnPagesTest.php
```

Формы урны: `create_urn_form`/`update_urn_form` подключают формы кашпо, а в них блок «Форма» (`collection`) показывается только для `pot`, данные берутся из `$product->{$productType}`. JS форм: страница урны подключает `create_pot_product.js` / `update_pot_product.js` (в них нет ничего про коллекцию).

## Complexity Tracking

Нет нарушений.
