# Tasks: Скрытый товар не открывается по прямой ссылке

**Input**: [spec.md](spec.md), [plan.md](plan.md), [research.md](research.md), [data-model.md](data-model.md), [contracts/routes.md](contracts/routes.md), [quickstart.md](quickstart.md)

Тест `tests/Feature/HiddenProductTest.php` — проверка правила для трёх типов; запуск — с разрешения пользователя.

## Phase 1: User Story 1 — скрытый товар отдаёт 404 (P1)

**Independent test**: quickstart пп. 1–4.

- [X] T001 [US1] Тест `tests/Feature/HiddenProductTest.php`: скрытая скамейка, кашпо, урна → 404; активные → 200; вошедший `admin` на скрытый товар → 404
- [X] T002 [P] [US1] `app/Http/Controllers/BenchController.php::show_bench_product`: в выборку товара по slug добавить `where('active', 1)`
- [X] T003 [P] [US1] `app/Http/Controllers/PotController.php::show_pot_product`: то же
- [X] T004 [P] [US1] `app/Repositories/UrnRepository.php::findBySlug`: то же

## Phase 2: Polish

- [X] T005 Прогнать `./vendor/bin/phpunit` (с разрешения пользователя) и quickstart
