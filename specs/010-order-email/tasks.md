# Tasks: Письмо по заказу из корзины

**Input**: [spec.md](spec.md), [plan.md](plan.md), [research.md](research.md), [data-model.md](data-model.md), [contracts/order-mail.md](contracts/order-mail.md), [quickstart.md](quickstart.md)

Новые тесты — в `tests/Feature/CartOrderTest.php`; запуск — с разрешения пользователя.

## Phase 1: Foundational

- [X] T001 Миграция `database/migrations/2026_11_25_120000_add_mail_failed_to_orders.php`: `orders.mail_failed` boolean default `false`
- [X] T002 `app/Models/Order.php`: `mail_failed` в fillable, cast boolean
- [X] T003 Применить миграцию в контейнере (`php artisan migrate`)

## Phase 2: User Story 1 — письмо о заказе (P1)

**Independent test**: тест «письмо ушло на адрес заявок с товарами».

- [X] T004 [P] [US1] `app/Mail/OrderMail.php` (тема «Заказ из корзины #<id>», markdown `mail.order_mail`) и `resources/views/mail/order_mail.blade.php` по образцу `feedback_mail`: имя, почта, телефон, организация, комментарий, товары, пустое — «—»
- [X] T005 [US1] `app/Services/CartService.php::place`: после сохранения отправить `OrderMail` на адрес заявок
- [X] T006 [US1] Тест в `CartOrderTest`: `Mail::fake`, заказ → одно `OrderMail` на адрес заявок, в нём все товары

## Phase 3: User Story 2 — сбой почты (P2)

**Independent test**: тест «сбой почты».

- [X] T007 [US2] `app/Repositories/OrderRepository.php::markMailFailed`
- [X] T008 [US2] `CartService::place`: отправку в `try/catch (\Throwable)`, `Log::error`, `markMailFailed`, дальше как сейчас
- [X] T009 [US2] `resources/views/elitvid/admin/orders/index.blade.php`: при `mail_failed` в строке заказа пометка «Письмо не отправлено»
- [X] T010 [US2] Тест в `CartOrderTest`: отправка бросает исключение → заказ сохранён с `mail_failed = true`, корзина пуста, «Заявка принята.», пометка видна в `admin_orders.index`

## Phase 4: Polish

- [X] T011 Прогнать `./vendor/bin/phpunit` (с разрешения пользователя) и quickstart
