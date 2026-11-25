# Quickstart: 011-hidden-product-404

1. Тесты (с разрешения пользователя): `make app`, затем `./vendor/bin/phpunit --filter HiddenProductTest`.
2. На http://localhost:8080: выбрать скрытую скамейку и скрытое кашпо в базе (`SELECT slug FROM products WHERE active = 0`), открыть их адреса — 404.
3. Открыть любой активный товар каждого типа — страница открывается.
4. В той же вкладке, вошедшей в админку, повторить п. 2 — 404.
