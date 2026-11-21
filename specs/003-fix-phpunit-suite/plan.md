# Implementation Plan: Рабочий набор автотестов

**Branch**: `003-fix-phpunit-suite` | **Date**: 2026-11-21 | **Spec**: [spec.md](./spec.md)

**Input**: Feature specification from `/specs/003-fix-phpunit-suite/spec.md`

## Summary

Сделать набор phpunit зелёным на пустой базе `elitvid_testing` без правок кода приложения. Для этого:

- `UserFactory` переводится на реальные поля `users`.
- Шесть тестов-заготовок Breeze на отсутствующие функции удаляются.
- `AuthenticationTest` переписывается под реальный вход `/login` и выход `/logout`.
- `CartOrderTest` начинает сам создавать товары и администратора на чистой схеме и берёт дату для фильтров из созданного заказа.

Подробности решений — [research.md](./research.md).

## Technical Context

**Language/Version**: PHP 8.5 (контейнер `php_elitvid`)

**Primary Dependencies**: Laravel 13, PHPUnit (из `vendor/`, версия по `composer.lock`)

**Storage**: MariaDB 10.3, база `elitvid_testing` для тестов; `elitvid_db` — база сайта, тесты её не трогают

**Testing**: `./vendor/bin/phpunit` внутри `php_elitvid`, трейт `RefreshDatabase`

**Target Platform**: локальный Docker (`make init`), http://localhost:8080

**Project Type**: web-service (Laravel, Blade + Inertia)

**Performance Goals**: нет отдельных целей; весь набор идёт секунды

**Constraints**: код приложения, маршруты, миграции не менять (FR-009); `elitvid_db` не трогать (FR-002)

**Scale/Scope**: 7 тестовых классов → 4 (`ExampleTest` ×2, `AuthenticationTest`, `CartOrderTest`), 1 фабрика

## Constitution Check

*GATE: Must pass before Phase 0 research. Re-check after Phase 1 design.*

`.specify/memory/constitution.md` — незаполненный шаблон, принципов в нём нет. Гейтов нет, нарушений нет.

Действующие правила workspace (`AGENTS.md`), которые выполняет план:

- Правка кода сайта идёт по спеке в `specs/` — эта спека.
- Тесты запускаются только с разрешения пользователя — разрешение дано 2026-11-21.
- После правок кода пересобрать граф `docs/ai/graphify-out/`.
- Commit — только по просьбе, push — никогда.

Повторная проверка после Phase 1: без изменений, PASS.

## Project Structure

### Documentation (this feature)

```text
specs/003-fix-phpunit-suite/
├── plan.md              # этот файл
├── research.md          # Phase 0
├── data-model.md        # Phase 1: какие данные готовят тесты
├── quickstart.md        # Phase 1: как проверить
├── checklists/requirements.md
└── tasks.md             # Phase 2 (/speckit-tasks)
```

`contracts/` не создаётся: фича не меняет внешних интерфейсов сайта.

### Source Code (repository root)

```text
database/factories/
└── UserFactory.php                         # изменить: username, role, active; убрать name, email_verified_at, unverified()

tests/Feature/
├── ExampleTest.php                         # без изменений
├── CartOrderTest.php                       # изменить: RefreshDatabase, свои товары и админ, дата из заказа
├── ProfileTest.php                         # удалить
└── Auth/
    ├── AuthenticationTest.php              # переписать: /login, вход, неверный пароль, /logout
    ├── EmailVerificationTest.php           # удалить
    ├── PasswordConfirmationTest.php        # удалить
    ├── PasswordResetTest.php               # удалить
    ├── PasswordUpdateTest.php              # удалить
    └── RegistrationTest.php                # удалить

tests/Unit/ExampleTest.php                  # без изменений
phpunit.xml                                 # без изменений: DB_DATABASE=elitvid_testing уже с force="true"
```

**Structure Decision**: структура проекта не меняется. Правки только в `tests/` и `database/factories/UserFactory.php`.

## Complexity Tracking

Нарушений нет, раздел не заполняется.
