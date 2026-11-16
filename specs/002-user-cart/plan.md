# Implementation Plan: Корзина и заявки

**Branch**: `002-user-cart` | **Date**: 2026-11-16 | **Spec**: [spec.md](spec.md)

**Input**: Feature specification from `/specs/002-user-cart/spec.md`

## Summary

Посетитель добавляет активную скамейку или кашпо целиком в корзину сеанса, меняет количество на странице корзины и отправляет заявку. Поля и проверка «я не робот» те же, что у окна заявки, файла нет. Заказ сохраняется в базе. Письмо не отправляется: текст заказа пишется в `storage/logs/laravel.log`. В админке список по 20 заказов, фильтр по дням и CSV, одна строка на заказ.

## Technical Context

**Language/Version**: PHP 8.1, Laravel 10, Blade

**Primary Dependencies**: существующие Laravel, сессии и проверка reCAPTCHA из `MailRequest`. Новых библиотек нет.

**Storage**: MariaDB `elitvid_db`, таблицы `orders` и `order_items`. Корзина — ключ сессии `cart`, не таблица.

**Testing**: ручная проверка по [quickstart.md](quickstart.md) на http://localhost:8080. Доказательство — строка заказа в `storage/logs/laravel.log`. Отдельный набор автоматических тестов не заводится: у публичных форм его сейчас нет.

**Target Platform**: локальный Docker-сайт, http://localhost:8080.

**Project Type**: серверный сайт с шаблонами Blade и админкой.

**Performance Goals**: список админки отдаёт 20 заказов на страницу. Выгрузка берёт всю выборку фильтра, не страницу.

**Constraints**: цепочка controller → request → DTO → service → repository. В сервисах и репозиториях нет методов, которые вызываются один раз: общий запрос фильтра вызывается и списком, и выгрузкой, чтение корзины — несколькими действиями. Размер, вес, цена и цвет в заказ не попадают. Письмо не уходит.

**Scale/Scope**: страница корзины, кнопка на двух страницах товара, пункт в админке, две таблицы.

## Constitution Check

*GATE: Must pass before Phase 0 research. Re-check after Phase 1 design.*

`.specify/memory/constitution.md` — пустой шаблон. Проверяемых запретов нет, нарушений нет.

Повторная проверка после Phase 1: новые таблицы и адреса описаны в спеке, новых библиотек нет. Ворота по-прежнему пустые и пройдены.

## Project Structure

### Documentation (this feature)

```text
specs/002-user-cart/
├── plan.md
├── research.md
├── data-model.md
├── quickstart.md
├── contracts/
│   ├── cart.md
│   ├── order-form.md
│   └── admin-orders.md
└── tasks.md
```

### Source Code (repository root)

```text
app/DTO/PlaceOrderData.php
app/DTO/OrderFilterData.php
app/Http/Controllers/CartController.php
app/Http/Controllers/Admin/OrderController.php
app/Http/Requests/AddToCartRequest.php
app/Http/Requests/UpdateCartRequest.php
app/Http/Requests/PlaceOrderRequest.php
app/Http/Requests/OrderFilterRequest.php
app/Models/Order.php
app/Models/OrderItem.php
app/Repositories/CartRepository.php
app/Repositories/OrderRepository.php
app/Services/CartService.php
app/Services/Admin/OrderService.php
database/migrations/2026_11_16_090000_create_orders_tables.php
resources/views/elitvid/site/cart.blade.php
resources/views/elitvid/admin/orders/index.blade.php
resources/views/components/elitvid/header.blade.php
resources/views/elitvid/site/benches/bench_product_page.blade.php
resources/views/elitvid/site/pots/pot_product_page.blade.php
resources/views/layouts/elitvid/admin/admin.blade.php
routes/web.php
```

**Structure Decision**: один Laravel-проект. Корзина и заявка — публичный контроллер. Список и CSV — админский контроллер с тем же доступом, что у раздела писем: `admin` и `manager`.

## Complexity Tracking

Нарушений конституции нет. Отдельное обоснование не требуется.
