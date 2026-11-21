# Research: Рабочий набор автотестов

Все факты проверены по коду 2026-11-21 (main, `3a7efb9`). Открытых вопросов нет.

## R1. Тесты Breeze: удалить или переписать

- **Decision**: удалить `EmailVerificationTest`, `PasswordConfirmationTest`, `PasswordResetTest`, `PasswordUpdateTest`, `RegistrationTest`, `ProfileTest`. `AuthenticationTest` переписать.
- **Rationale**: в `routes/web.php` есть только `GET/POST /login` (`LoginController@index/login`) и `GET /logout`. Регистрации, сброса и подтверждения пароля, подтверждения почты, профиля и `/dashboard` нет. В таблице `users` нет колонки `email_verified_at`. Тесты на эти функции проверяют то, чего на сайте нет (FR-008).
- **Alternatives considered**: пометить тесты `markTestSkipped` — отклонено: мёртвый код остаётся, а «пропущено» в отчёте маскирует набор.

## R2. Поля UserFactory

- **Decision**: `username`, `email` (уникальный), `password` (строка `password`, модель хеширует её сама через cast `hashed`), `role` = `viewer`, `active` = `true`. Тесты задают `role` явно, когда нужен админ.
- **Rationale**: колонки `users` по миграциям `2014_10_12_000000_create_users_table` и `2026_07_03_110406_add_roles_to_users_table`: `username`, `email`, `password`, `remember_token`, `role` (enum `admin|manager|viewer`, по умолчанию `viewer`), `active` (по умолчанию `true`). Колонок `name` и `email_verified_at` нет. `User::$casts['password'] = 'hashed'`.
- **Alternatives considered**: отдельные состояния `admin()` и `manager()` — отклонено: нужен один админ в одном тесте, хватит `create(['role' => 'admin'])`.

## R3. Что считается входом и отказом

- **Decision**:
  - Успешный вход: `POST /login` с верными email и паролем → редирект на `route('admin')`, пользователь авторизован.
  - Неверный пароль: редирект на `route('login')`, гость.
  - Выход: `GET /logout` → гость, редирект на `route('login')`.
  - Страница входа: `GET /login` у гостя отдаёт 200.
- **Rationale**: так работает `Admin\Auth\LoginController`. Неудачный вход не пишет ошибку в сессию, только `withInput()`, поэтому тест проверяет гостя и редирект, а не текст ошибки.
- **Alternatives considered**: проверять сообщение об ошибке — отклонено: контроллер его не выдаёт, а менять код нельзя (FR-009).

## R4. Данные для CartOrderTest

- **Decision**: тест подключает `RefreshDatabase` и сам создаёт:
  - два товара через `Product::create`: `CUBE` с `product_type = pot` и `KOLONNA` с `product_type = bench`, оба `active = true`;
  - администратора через `UserFactory` с `role = admin`.

  Корзина в сессии строится из id созданных товаров, а не из констант 1 и 2.
- **Rationale**: `CartService::lines()` считает товар доступным, если он есть, `active`, `deleted_at === null` и `product_type` из `bench|pot`. У `Product` нет фабрики, а заводить её ради двух строк не нужно. Без `RefreshDatabase` схема в `elitvid_testing` зависит от того, какой тест шёл раньше.
- **Alternatives considered**: сидер с тестовыми товарами — отклонено: данные нужны одному тесту.

## R5. Дата в фильтре и выгрузке

- **Decision**: дату фильтра брать из созданного заказа: `Order::first()->created_at->toDateString()`. Для «будущей» даты брать следующий день после неё.
- **Rationale**: `OrderRepository` фильтрует через `whereDate('created_at', …)`, часовой пояс приложения — `UTC`. Дата из самого заказа совпадает с тем, что сравнивает запрос, в любой день и около полуночи (edge case спеки). Зашитая `2026-11-16` ломает тест в любой другой день.
- **Alternatives considered**: `Carbon::setTestNow()` — рабочий вариант, но дата из заказа проще и не трогает часы.

## R6. Изоляция от elitvid_db

- **Decision**: `phpunit.xml` не менять.
- **Rationale**: там уже `<env name="DB_DATABASE" value="elitvid_testing" force="true"/>`. `force` перекрывает значение из `.env`. Запуск 2026-11-21 подтвердил: в `elitvid_db` до и после 27 таблиц, 1 пользователь, 0 заказов. Если базы `elitvid_testing` нет, подключение падает и не переключается на `elitvid_db`.
- **Alternatives considered**: SQLite in-memory — отклонено: миграции и `whereDate` проверяются на той же СУБД, что у сайта.
