# Quickstart: 010-order-email

1. Миграция (по спеке): `make app`, затем `php artisan migrate`.
2. Тесты (с разрешения пользователя): `./vendor/bin/phpunit --filter CartOrderTest`.
3. Живой заказ на http://localhost:8080 не оформлять без разрешения: локальный `.env` шлёт почту через SMTP на настоящий адрес заявок. Отправку и сбой почты проверяют тесты (п. 2, `Mail::fake`).
4. В «Заказах» на http://localhost:8080/admin/orders страница открывается, колонки прежние.
