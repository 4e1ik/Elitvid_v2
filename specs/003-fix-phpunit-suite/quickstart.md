# Quickstart: проверка набора автотестов

## Подготовка

1. Контейнеры подняты: `docker compose ps` показывает `php_elitvid` и `elitvid_db`.
2. Создать тестовую базу, если её ещё нет (повторный запуск безопасен):

   ```bash
   make test-db
   ```

3. Снимок базы сайта до запуска:

   ```bash
   docker exec elitvid_db mysql -uroot -proot -N -e "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='elitvid_db'; SELECT COUNT(*) FROM elitvid_db.users; SELECT COUNT(*) FROM elitvid_db.orders;"
   ```

## Проверки

| # | Что | Команда | Ожидание |
|---|-----|---------|----------|
| 1 | Весь набор (SC-001) | `docker exec -e XDEBUG_MODE=off php_elitvid ./vendor/bin/phpunit` | `OK`, 0 errors, 0 failures |
| 2 | Повторный запуск (SC-002) | та же команда ещё раз | снова `OK` |
| 3 | База сайта не тронута (SC-003) | команда снимка из подготовки | те же три числа |
| 4 | Нет тестов на отсутствующие страницы (SC-004) | `grep -rnE "register\|forgot-password\|reset-password\|verify-email\|confirm-password\|profile\|dashboard" tests` | пусто |
| 5 | Тест корзины ловит поломку (SC-005) | см. ниже | тест падает, после отката проходит |

### Проверка 5: тест корзины действительно проверяет заказ

1. Временно закомментировать в `app/Services/CartService.php` строку `$order = $this->orders->create($data, $stored);` и следующие за ней строки до `return`. Вместо них вернуть `return new \App\Models\Order();`.
2. Запустить тест корзины:

   ```bash
   docker exec -e XDEBUG_MODE=off php_elitvid ./vendor/bin/phpunit --filter CartOrderTest
   ```

   Ожидание: FAIL на `assertDatabaseHas('orders', …)`.
3. Откатить файл и убедиться, что правок не осталось:

   ```bash
   git restore app/Services/CartService.php && git diff --quiet app && echo clean
   ```

4. Повторить шаг 2. Ожидание: OK.

## После проверки

- Пересобрать граф (правило `AGENTS.md`), из корня `Elitvid_v2`:

  ```bash
  graphify extract . --code-only --out docs/ai
  ```

  ```bash
  graphify cluster-only docs/ai --no-viz --no-label
  ```

  Удалить `graphify-out/` в корне `Elitvid_v2`, если появился.
- `git diff --stat` затрагивает только `tests/` и `database/factories/UserFactory.php` (не считая `specs/` и `docs/ai/graphify-out/`).
