# Quickstart: проверка объединения кашпо

## Подготовка

1. Сайт поднят (`make init` уже был), http://localhost:8080 открывается.
2. Миграция: `docker compose exec php-fpm php artisan migrate`.
3. Если базу перезаливали `make db-import`, повторить шаг 2: дамп содержит старые коллекции.

## Автотесты (с разрешения пользователя)

```bash
docker compose exec php-fpm ./vendor/bin/phpunit --filter SquareRectangularPotsTest
```

Ожидание: все тесты зелёные. Покрыто: страница 200 со всеми товарами обеих бывших коллекций, 4 перенаправления 301, sitemap, плитка каталога.

## Ручной сценарий

1. `/napravleniya/kashpo` — в блоке «Формы» две плитки: «Круглые» и «Квадратные и прямоугольные» с картинкой квадратного кашпо.
2. Плитка ведёт на `/napravleniya/kashpo/kvadratnye-i-pryamougolnye`. Заголовок «Квадратные и прямоугольные кашпо». Товары: `kolonna`, `box`, `corob`, `cube`, `piramida`. Мета-заголовок — бывший прямоугольный.
3. Открыть `cube`: адрес `/napravleniya/kashpo/kvadratnye-i-pryamougolnye/cube`. Ссылка на направление — «Квадратные и прямоугольные кашпо», похожие товары ведут на новый сегмент.
4. Проверить перенаправления: `curl -sI http://localhost:8080/napravleniya/kashpo/kvadratnye/cube` → `301`, `Location: …/kvadratnye-i-pryamougolnye/cube`. То же для `/pryamougolnye/box`, `/kvadratnye`, `/pryamougolnye`.
5. `/sitemap.xml` — нет `kvadratnye/` и `pryamougolnye/` по отдельности.
6. Админка (вход из `.env`): в меню один пункт «Квадратные и прямоугольные кашпо» в товарах и в картинках страниц. Список — 5 товаров. В форме создания и редактирования кашпо варианты коллекции: «Круглое кашпо» и «Квадратные и прямоугольные кашпо».
7. «Круглые кашпо» `/napravleniya/kashpo/kruglye` открываются как раньше.

## Откат

`docker compose exec php-fpm php artisan migrate:rollback --step=1` → `cube` и `piramida` снова `Square`, остальные `Rectangular`, тексты на ключе `rectangular_pots`. Код при этом надо откатить отдельно.
