# Implementation Plan: Главная картинка товара

**Branch**: `013-product-main-image` | **Date**: 2026-11-26 | **Spec**: [spec.md](spec.md)

**Input**: Feature specification from `/specs/013-product-main-image/spec.md`

## Summary

Флаг `images.main_image` уже есть в базе и уже пишется `ImageService::save` из `image_data[i][main_image]`, но для товаров не читается. План: метод `Product::mainImage()` (отмеченная, иначе с наименьшим `id`), чекбокс в формах админки, снятие флага с остальных картинок товара при отметке, вывод `mainImage()` в карточках и на странице товара, начальный цвет и текстура переключателей из главной картинки, миграция данных: пористая «слоновая кость» — главная.

## Technical Context

**Language/Version**: PHP 8.5, Laravel 13, Blade, ванильный JS в `public/elitvid_assets/newDesign/newDesign/js/`

**Primary Dependencies**: существующие `ImageService`, `ProductService`, `Admin\ImageController`

**Storage**: MariaDB, таблица `images` (полиморфная, `imageable_type = App\Models\Product`), колонка `main_image` уже есть

**Testing**: PHPUnit, `tests/Feature`, база `elitvid_testing`

**Target Platform**: веб, http://localhost:8080

**Project Type**: монолит Laravel (сайт + админка)

**Performance Goals**: без новых запросов: `mainImage()` работает по уже загруженной связи `images`

**Constraints**: не менять поведение `main_image` у блога, статических страниц и галерей

**Scale/Scope**: 82 товара (50 скамеек, 27 кашпо, 5 урн)

## Constitution Check

`.specify/memory/constitution.md` — незаполненный шаблон, принципов нет. Ворота не заданы, нарушений нет. Действуют правила `AGENTS.md`: спека есть, база меняется только миграцией этой задачи.

## Project Structure

### Documentation (this feature)

```text
specs/013-product-main-image/
├── plan.md
├── research.md
├── data-model.md
├── quickstart.md
├── contracts/admin-forms.md
└── tasks.md
```

### Source Code (repository root)

```text
app/Models/Product.php                          # mainImage()
app/Services/ImageService.php                   # снятие флага с остальных картинок товара
app/Http/Requests/UpdateImageRequest.php        # main_image: sometimes|boolean
database/migrations/2026_11_26_000000_set_product_main_images.php
resources/views/includes/elitvid/admin/update_product.blade.php
resources/views/components/elitvid/collection-page.blade.php
resources/views/elitvid/site/urns.blade.php
resources/views/elitvid/site/pots/square_rectangular_pots.blade.php
resources/views/elitvid/site/{pots/pot,benches/bench,urns/urn}_product_page.blade.php
public/elitvid_assets/newDesign/newDesign/js/{create,update}_{pot,bench}_product.js
public/elitvid_assets/newDesign/newDesign/js/imageUpdater.js
tests/Feature/ProductMainImageTest.php
```

**Structure Decision**: правки в существующих слоях, новых классов нет.

## Complexity Tracking

Нарушений нет.
