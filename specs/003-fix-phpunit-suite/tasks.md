---

description: "Задачи: рабочий набор автотестов"
---

# Tasks: Рабочий набор автотестов

**Input**: Design documents from `/specs/003-fix-phpunit-suite/`

**Prerequisites**: plan.md, spec.md, research.md, data-model.md, quickstart.md

**Tests**: сама фича — это тесты. Отдельных «тестов на тесты» нет. Проверка, что тест корзины ловит поломку, — задача T007 (SC-005).

**Organization**: задачи сгруппированы по историям из spec.md.

## Format: `[ID] [P?] [Story] Description`

- **[P]**: можно делать параллельно (разные файлы, нет зависимостей)
- **[Story]**: история из spec.md (US1, US2, US3)

## Path Conventions

Пути от корня `Elitvid_v2`. Все команды phpunit — в контейнере: `docker exec -e XDEBUG_MODE=off php_elitvid ./vendor/bin/phpunit …`.

---

## Phase 1: Setup

**Purpose**: окружение для запуска и снимок базы сайта

- [X] T001 Проверить, что база `elitvid_testing` существует (`docker exec elitvid_db mysql -uroot -proot -N -e "SHOW DATABASES LIKE 'elitvid_testing'"`); если нет — создать командой из specs/003-fix-phpunit-suite/quickstart.md, раздел «Подготовка»
- [X] T002 Записать снимок `elitvid_db` (число таблиц, `users`, `orders`) командой из specs/003-fix-phpunit-suite/quickstart.md, раздел «Подготовка», шаг 3

---

## Phase 2: Foundational

**Purpose**: фабрика пользователя, без которой не работают ни US1, ни US2

**⚠️ CRITICAL**: US1 и US2 начинать после T003

- [X] T003 Переписать `definition()` в database/factories/UserFactory.php: `username` — `fake()->userName()`, `email` — `fake()->unique()->safeEmail()` (колонка уникальна), `password` — строка `password` (модель хеширует сама, cast `hashed`), `role` — `viewer` (одно из `admin`, `manager`, `viewer`), `active` — `true`, `remember_token` — `Str::random(10)`. Удалить ключи `name` и `email_verified_at` и метод `unverified()`: колонок `name` и `email_verified_at` в `users` нет

**Checkpoint**: фабрика создаёт пользователя без ошибок SQL

---

## Phase 3: User Story 1 — Тест корзины проверяет оформление заявки (Priority: P1) 🎯 MVP

**Goal**: `CartOrderTest` проходит на пустой `elitvid_testing` в любой день

**Independent Test**: `phpunit --filter CartOrderTest` → OK; снимок `elitvid_db` не изменился

- [X] T004 [US1] В tests/Feature/CartOrderTest.php подключить `Illuminate\Foundation\Testing\RefreshDatabase`. В начале теста создать через `App\Models\Product::create` товар `name = CUBE`, `product_type = pot`, `active = true` и товар `name = KOLONNA`, `product_type = bench`, `active = true`. Админа создать через `User::factory()->create(['role' => 'admin'])` вместо `User::query()->where('role', 'admin')->first()`. Сессию корзины собрать из id созданных товаров (`[$cube->id => 2, $kolonna->id => 1]`), в `assertDatabaseHas('order_items', …)` подставить те же id вместо 1 и 2
- [X] T005 [US1] В tests/Feature/CartOrderTest.php убрать зашитую дату `2026-11-16`. После `POST /cart/order` взять `$day = App\Models\Order::firstOrFail()->created_at->toDateString()`, передать `$day` в `date_from` и `date_to` выгрузки, а для проверки «будущей» даты использовать `Carbon::parse($day)->addDay()->toDateString()` вместо `2099-01-01`. Остальные проверки (редирект на `cart.show`, `orders`, `order_items`, список, CSV-заголовок, строка `CUBE × 2; KOLONNA × 1`) оставить
- [X] T006 [US1] Запустить `phpunit --filter CartOrderTest` → OK
- [X] T007 [US1] Проверка SC-005 по specs/003-fix-phpunit-suite/quickstart.md, «Проверка 5»: временно сломать сохранение заказа в app/Services/CartService.php, убедиться, что `CartOrderTest` падает, затем `git restore app/Services/CartService.php`, проверить `git diff --quiet app` и повторно получить OK

**Checkpoint**: US1 работает отдельно от остальных историй

---

## Phase 4: User Story 2 — Тесты входа проверяют реальный вход в админку (Priority: P2)

**Goal**: `AuthenticationTest` проверяет `/login` и `/logout` так, как они работают на сайте

**Independent Test**: `phpunit --filter AuthenticationTest` → OK

- [X] T008 [P] [US2] Переписать tests/Feature/Auth/AuthenticationTest.php (оставить `RefreshDatabase`), ровно четыре теста:
  - (1) гость: `GET /login` → 200;
  - (2) `User::factory()->create()`, `POST /login` с его `email` и паролем `password` → `assertAuthenticatedAs($user)` и редирект на `route('admin')`;
  - (3) тот же пользователь с паролем `wrong-password` → `assertGuest()` и редирект на `route('login')`;
  - (4) `actingAs($user)` и `GET /logout` → `assertGuest()` и редирект на `route('login')`.

  Убрать импорт и любые ссылки на `/dashboard` и `RouteServiceProvider`. Текст ошибки входа не проверять: контроллер его не выдаёт
- [X] T009 [US2] Запустить `phpunit --filter AuthenticationTest` → OK

**Checkpoint**: US2 работает отдельно

---

## Phase 5: User Story 3 — В наборе нет тестов на несуществующие функции (Priority: P3)

**Goal**: в `tests/` только тесты на то, что есть на сайте

**Independent Test**: grep из quickstart (проверка 4) пуст

- [X] T010 [P] [US3] Удалить tests/Feature/Auth/EmailVerificationTest.php, tests/Feature/Auth/PasswordConfirmationTest.php, tests/Feature/Auth/PasswordResetTest.php, tests/Feature/Auth/PasswordUpdateTest.php, tests/Feature/Auth/RegistrationTest.php, tests/Feature/ProfileTest.php
- [X] T011 [US3] Выполнить `grep -rnE "register|forgot-password|reset-password|verify-email|confirm-password|profile|dashboard" tests` → пусто

**Checkpoint**: все три истории готовы

---

## Phase 6: Polish & Cross-Cutting Concerns

- [X] T012 Запустить весь набор `phpunit` дважды подряд → оба раза `OK`, 0 errors, 0 failures (SC-001, SC-002)
- [X] T013 Повторить снимок `elitvid_db` из T002 и сравнить: три числа совпадают (SC-003)
- [X] T014 Пересобрать граф из корня `Elitvid_v2`: `graphify extract . --code-only --out docs/ai`, затем `graphify cluster-only docs/ai --no-viz --no-label`; удалить `graphify-out/` в корне `Elitvid_v2`, если появился (правило AGENTS.md)
- [X] T015 `git status` и `git diff --stat`: изменены только database/factories/UserFactory.php и файлы в tests/ (плюс specs/003-fix-phpunit-suite/ и docs/ai/graphify-out/); в app/, routes/, database/migrations/, phpunit.xml правок нет (FR-009). Не коммитить без просьбы

---

## Phase 7: Дополнение — создание тестовой базы (FR-010)

- [X] T016 Добавить в Makefile цель `test-db`: `CREATE DATABASE IF NOT EXISTS elitvid_testing CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci` через `docker exec elitvid_db mysql -uroot -proot`
- [X] T017 В scripts/init.sh в `main()` сразу после `wait_for_mysql` создать ту же базу тем же SQL через `mysql_exec`, чтобы её создавал подъём с нуля
- [X] T018 Проверка: удалить `elitvid_testing`, выполнить `make test-db` дважды (второй раз без ошибки), прогнать весь `phpunit` → OK; `bash -n scripts/init.sh`; снимок `elitvid_db` не изменился

---

## Dependencies & Execution Order

- **Setup (T001–T002)** → **Foundational (T003)** → US1 и US2.
- **US1 (T004–T007)** зависит от T003. T005 после T004 (один файл). T006 после T005. T007 после T006.
- **US2 (T008–T009)** зависит от T003, от US1 не зависит.
- **US3 (T010–T011)** не зависит ни от чего, можно делать сразу после Setup.
- **Polish (T012–T015)** — после всех историй: зелёный весь набор возможен только когда сделаны US1, US2 и US3.

## Parallel Example

```text
После T003 одновременно:
  T004–T007 [US1] tests/Feature/CartOrderTest.php
  T008      [US2] tests/Feature/Auth/AuthenticationTest.php
  T010      [US3] удаление шести файлов
```

T007 временно правит app/Services/CartService.php. Пока он идёт, полный набор (T012) не запускать.

## Implementation Strategy

1. **MVP**: Setup → T003 → US1. Тест корзины снова проверяет заявки — главная ценность фичи.
2. US2: вход в админку покрыт тестами.
3. US3: набор чистый, и весь прогон зелёный (T012).
4. Polish: снимок базы, граф, проверка границ правок.
