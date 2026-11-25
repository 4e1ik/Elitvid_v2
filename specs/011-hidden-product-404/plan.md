# Implementation Plan: Скрытый товар не открывается по прямой ссылке

**Branch**: `011-hidden-product-404` | **Date**: 2026-11-25 | **Spec**: [spec.md](spec.md)

## Summary

Страницы товара (`show_bench_product`, `show_pot_product`, `show_urn_product`) ищут товар по `slug` без признака `active`. Достаточно добавить условие `active = 1` в эти три выборки: скрытый товар не найдётся, и сработает уже существующий путь `abort(404)`. Новых маршрутов, данных и слоёв нет.

## Technical Context

- PHP 8.5, Laravel 13, Blade — без новых библиотек.
- Хранилище: без изменений, поле `products.active` уже есть.
- Тесты: новый `tests/Feature/HiddenProductTest.php` (скамейка, кашпо, урна: скрытая → 404, активная → 200; вошедший admin → 404). Запуск `./vendor/bin/phpunit` — с разрешения пользователя.
- Ограничения: списки, корзина, sitemap и перенаправления Street furniture не меняются (FR-004).

## Constitution Check

`.specify/memory/constitution.md` — пустой шаблон, действуют правила `AGENTS.md`.

- Маршруты не меняются; имена `show_bench_product`, `show_pot_product`, `show_urn_product` подтверждены в `routes/web.php` — PASS.
- Урна читается через `UrnRepository::findBySlug` — условие добавляется туда, в единственный слой запросов — PASS.
- Скамейка и кашпо читают `Product` прямо в контроллере (старый код вне слоёв). Правка — одно условие в существующей выборке; перенос в репозиторий не входит в задачу («не трогать соседнее») — PASS с оговоркой.
- Правило «скрытый товар не показывать» живёт на бэкенде, вьюха не меняется — PASS.

## Project Structure

```text
app/Http/Controllers/BenchController.php     # show_bench_product: + where('active', 1)
app/Http/Controllers/PotController.php       # show_pot_product: + where('active', 1)
app/Repositories/UrnRepository.php           # findBySlug: + where('active', 1)
tests/Feature/HiddenProductTest.php          # новый
```

## Complexity Tracking

Нет нарушений.
