# Implementation Plan: Объединение квадратных и прямоугольных кашпо

**Branch**: `012-merge-square-rect-pots` | **Date**: 2026-11-25 | **Spec**: [spec.md](spec.md)

## Summary

Коллекции `Square` и `Rectangular` у кашпо сливаются в одну, `Square_rectangular`, с сегментом адреса `kvadratnye-i-pryamougolnye`. Тексты и картинки страницы переходят с ключа `rectangular_pots` на новый ключ `square_rectangular_pots`. Всё это делает одна миграция данных. Страница направления — это бывшая страница прямоугольных кашпо: тот же шаблон, новые заголовок, маршрут и сегмент. Старые адреса страниц и товаров отвечают постоянным перенаправлением (`Route::permanentRedirect`), как у Street furniture в спеке 006. Админка, крошки, sitemap и плитка каталога переключаются на одно направление. Круглые кашпо не трогаются.

Эта задача закрывает вопрос FR-002 из `specs/005-pots-redesign` (адрес, перенаправление, картинка формы). Перевёрстка страницы в новый вид (`x-elitvid.collection-page`) и FR-005 «классическое кашпо и дикий камень» остаются в спеке 005 и сюда не входят.

## Technical Context

- PHP 8.5, Laravel 13, Blade — без новых библиотек.
- Хранилище: MySQL `elitvid_db`. Меняются данные, схема не меняется: `pots.collection` (строка), `page_contents.page`, `static_images.page`. Галерей с типами `square_pots`/`rectangular_pots` нет (проверено `SELECT`).
- Сейчас в базе: 2 товара `Square` (`cube`, `piramida`) и 3 товара `Rectangular` (`kolonna`, `box`, `corob`), все активны.
- Тесты: новый `tests/Feature/SquareRectangularPotsTest.php`. Запуск `./vendor/bin/phpunit` — с разрешения пользователя.
- Ограничения: маршрут `/{collection}/{slug}` принимает любой сегмент. Чтобы перенаправления работали, их нужно объявить раньше него.

## Constitution Check

`.specify/memory/constitution.md` — пустой шаблон, действуют правила `AGENTS.md`.

- Новые маршруты и имена объявляются в `routes/web.php`. Существующие имена подтверждены там же — PASS.
- Новых слоёв нет. Изменения точечные, внутри уже существующих методов контроллеров (`PotController`, `Admin\PotController`), которые и так читают `Product` напрямую. Перенос в репозитории — «соседнее», не делаем — PASS с оговоркой.
- Миграция данных идёт по этой спеке — PASS.
- Соответствие «коллекция → сегмент адреса» живёт в `config/collections.php` (бэкенд), вьюхи берут сегмент оттуда или из маршрута — PASS.
- `make db-import` перезальёт старые данные. После него нужен `php artisan migrate` (миграция данных идемпотентна) — оговорка в quickstart.

Повторная проверка после Phase 1: нарушений нет.

## Project Structure

```text
database/migrations/2026_11_25_120000_merge_square_rectangular_pots.php   # новая: данные
config/collections.php                       # pot_url_segments: Square/Rectangular → Square_rectangular
routes/web.php                               # новая страница + 4 перенаправления; админ: один маршрут
routes/breadcrumbs.php                       # square_rectangular_pots вместо двух
app/Http/Controllers/PotController.php       # square_rectangular_pots() вместо square_pots()/rectangular_pots()
app/Http/Controllers/Admin/PotController.php # square_rectangular_pots() вместо двух
app/Http/Controllers/SitemapController.php   # одна страница вместо двух
app/Helpers/ProductRouteCreatingHelper.php   # Square_rectangular → admin_square_rectangular_pots
resources/views/elitvid/site/pots.blade.php                          # одна плитка (картинка square_pot.webp)
resources/views/elitvid/site/pots/square_rectangular_pots.blade.php  # бывший rectangular_pots.blade.php
resources/views/elitvid/site/pots/square_pots.blade.php              # удалить
resources/views/elitvid/site/pots/pot_product_page.blade.php         # ссылка и название направления
resources/views/elitvid/admin/pots/pots_square_rectangular.blade.php # бывший pots_rectangular.blade.php
resources/views/elitvid/admin/pots/pots_square.blade.php             # удалить
resources/views/includes/elitvid/admin/create_pot_form.blade.php     # один вариант коллекции
resources/views/includes/elitvid/admin/update_pot_form.blade.php     # один вариант коллекции
resources/views/layouts/elitvid/admin/admin.blade.php                # меню: товары и картинки страниц (2 места × 2)
tests/Feature/SquareRectangularPotsTest.php                          # новый
```

`resources/views/elitvid/admin/pots/pots.blade.php` нигде не рендерится (ни один контроллер не отдаёт `elitvid.admin.pots.pots`). Его не трогаем.

## Complexity Tracking

Нет нарушений.
