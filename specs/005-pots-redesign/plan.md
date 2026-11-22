# Implementation Plan: Кашпо в новом виде

**Branch**: `005-pots-redesign` | **Date**: 2026-11-21 | **Spec**: [spec.md](spec.md)

## Summary

Перевести «Вазоны и кашпо» и «Круглые кашпо» на каркас редизайна (`rd-page`, `rd-hero`, компоненты `components/elitvid/*`, `redesign.css`), заменить в карточке товара фактуры, цвета и кнопки корзины. Состав форм меняется через админку (выключение/добавление товаров), без миграций.

## Technical Context

- PHP 8.5, Laravel 13, Blade, jQuery, Swiper — без новых библиотек.
- Хранилище не меняется. Новые картинки первого экрана — `public/elitvid_assets/redesign/images/`.
- Корзина (спека 002): `cart.add`, `cart.update` с `quantity=0` убирает товар; `CartService` отдаёт строки корзины. Признак «товар в корзине» считает бэкенд и передаёт во вьюху.
- Проверка — `quickstart.md` на 1440 и 320 px; `tests/Feature/CartOrderTest.php` — с разрешения пользователя.

## Constitution Check

- Маршруты только существующие (`pots`, `round_pots`, `show_pot_product`, `cart.*`) — PASS.
- Правило «товар в корзине» на бэкенде, вьюха берёт готовое значение — PASS.
- Повторяемые части — в `components/elitvid/` (крошки, карточка формы) — PASS.
- Тексты из админки (`category_description`, галерея) не хардкодятся — PASS.
- Новый серверный код по цепочке Controller → Service; новый метод сервиса только если нужен (проверка «в корзине») — PASS.

## Project Structure

```text
routes/breadcrumbs.php                                   # «Каталог», «Вазоны и кашпо»
app/Http/Controllers/PotController.php                   # inCart для карточки
app/Services/CartService.php                             # has(productId) — если нет готового
resources/views/components/elitvid/breadcrumbs.blade.php # крошки нового вида
resources/views/components/elitvid/form-row.blade.php    # строка «Формы»
resources/views/elitvid/site/pots.blade.php
resources/views/elitvid/site/pots/round_pots.blade.php
resources/views/elitvid/site/pots/pot_product_page.blade.php
public/elitvid_assets/redesign/redesign.css, redesign.js / cart-add.js
public/elitvid_assets/redesign/images/round-pots-hero.webp
```

## Complexity Tracking

Нет нарушений.
