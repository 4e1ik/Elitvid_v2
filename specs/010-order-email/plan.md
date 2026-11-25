# Implementation Plan: Письмо по заказу из корзины

**Branch**: `010-order-email` | **Date**: 2026-11-25 | **Spec**: [spec.md](spec.md)

## Summary

После сохранения заказа `CartService::place` отправляет новое письмо `OrderMail` на адрес заявок (`el_vid@mail.ru`, как в `MailController::send`). Сбой отправки ловится: ошибка пишется в журнал, у заказа ставится `mail_failed = true`, сценарий продолжается как сейчас (корзина очищается, «Заявка принята.»). В таблице «Заказы» у такого заказа видна пометка «Письмо не отправлено».

## Technical Context

- PHP 8.5, Laravel 13, Blade, Laravel Mail (SMTP, как у формы заявки) — без новых библиотек.
- Хранилище: миграция `orders.mail_failed` boolean, default `false`. Старые заказы получают `false` и пометки не имеют (FR-005).
- Отправка синхронная, как `FeedbackMail` в `MailController::send`.
- Тесты: в `tests/Feature/CartOrderTest.php` добавить: письмо ушло на адрес заявок с товарами (`Mail::fake`); сбой почты → заказ сохранён, `mail_failed = true`, корзина пуста, пометка видна в `admin_orders.index`. Запуск `./vendor/bin/phpunit` — с разрешения пользователя.
- Ограничения: форма «Оставить заявку», CSV и права «Заказов» не меняются (FR-006).

## Constitution Check

`.specify/memory/constitution.md` — пустой шаблон, действуют правила `AGENTS.md` и `resources/views/AGENTS.md`.

- Слои: Controller (`CartController::place`, без изменений) → Request/DTO (без изменений) → Service (`CartService::place` — отправка и обработка сбоя) → Repository (`OrderRepository::markMailFailed`) — PASS.
- Service к модели напрямую не пишет: признак ставит репозиторий — PASS.
- Маршруты не меняются; `cart.place`, `admin_orders.index` подтверждены в `routes/web.php` — PASS.
- Вид админки меняется по спеке (FR-004): одна пометка в существующей таблице — PASS.
- Адрес получателя повторяется литералом в `CartService`; вынос общего адреса затронул бы `MailController` (FR-006) — PASS с оговоркой, см. research.md.

## Project Structure

```text
database/migrations/2026_11_25_120000_add_mail_failed_to_orders.php  # новая
app/Models/Order.php                          # fillable + cast mail_failed
app/Mail/OrderMail.php                        # новый Mailable
resources/views/mail/order_mail.blade.php     # новый шаблон, по образцу feedback_mail
app/Services/CartService.php                  # place: отправка, try/catch, журнал
app/Repositories/OrderRepository.php          # markMailFailed
resources/views/elitvid/admin/orders/index.blade.php  # пометка в строке заказа
tests/Feature/CartOrderTest.php               # новые тесты
```

## Complexity Tracking

Нет нарушений.
