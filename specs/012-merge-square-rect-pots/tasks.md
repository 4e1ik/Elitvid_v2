# Tasks: Объединение квадратных и прямоугольных кашпо

**Input**: [spec.md](spec.md), [plan.md](plan.md), [research.md](research.md), [data-model.md](data-model.md), [contracts/routes.md](contracts/routes.md), [quickstart.md](quickstart.md)

Тест `tests/Feature/SquareRectangularPotsTest.php` проверяет страницу, перенаправления, sitemap и плитку каталога. Запуск — только с разрешения пользователя.

Имена, общие для всех задач:

| Что | Значение |
|---|---|
| Коллекция | `Square_rectangular` |
| Сегмент адреса | `kvadratnye-i-pryamougolnye` |
| Ключ страницы | `square_rectangular_pots` |
| Маршрут сайта | `square_rectangular_pots` |
| Маршрут админки | `admin_square_rectangular_pots` |
| Название | «Квадратные и прямоугольные кашпо» |

## Phase 1: Foundational (блокирует все истории)

- [X] T001 Миграция `database/migrations/2026_11_25_130000_merge_square_rectangular_pots.php` по [data-model.md](data-model.md).
  - `up()`:
    - создать таблицу `pots_square_backup` (`pot_id` bigint) и записать в неё id строк `pots`, у которых `collection = 'Square'`;
    - `pots.collection` `Square` и `Rectangular` → `Square_rectangular`;
    - `page_contents.page` и `static_images.page` `rectangular_pots` → `square_rectangular_pots`;
    - повторный запуск безопасен: условия `where` отбирают только старые значения, таблица создаётся через `Schema::hasTable`.
  - `down()`:
    - `Square_rectangular` → `Rectangular`;
    - id из `pots_square_backup` → `Square`;
    - `square_rectangular_pots` → `rectangular_pots` в обеих таблицах;
    - удалить `pots_square_backup`.
- [X] T002 [P] `config/collections.php`: в `pot_url_segments` заменить пары `Square` и `Rectangular` одной парой `'Square_rectangular' => 'kvadratnye-i-pryamougolnye'`. В `config/pages.php` (названия в «Контенте страниц») ключ `rectangular_pots` → `'square_rectangular_pots' => 'Квадратные и прямоугольные кашпо'`; `square_pots` остаётся (строка в базе не удаляется).

## Phase 2: User Story 1 — одна страница направления на сайте (P1)

**Goal**: каталог ведёт на одну страницу, где собраны все 5 товаров.

**Independent test**: [quickstart](quickstart.md), пп. 1–3.

- [X] T003 [US1] Тесты в `tests/Feature/SquareRectangularPotsTest.php`, образец — `tests/Feature/BenchRedirectTest.php`:
  - `GET /napravleniya/kashpo/kvadratnye-i-pryamougolnye` → 200; на странице есть «Квадратные и прямоугольные» и имена двух активных товаров `Square_rectangular`;
  - `/napravleniya/kashpo` содержит `route('square_rectangular_pots')` и не содержит `/kashpo/kvadratnye"` и `/kashpo/pryamougolnye"`;
  - страница товара `/napravleniya/kashpo/kvadratnye-i-pryamougolnye/{slug}` → 200, ссылка на направление ведёт на новую страницу.
- [X] T004 [US1] `routes/web.php`, группа `kashpo`: вместо групп `pryamougolnye` и `kvadratnye` — `Route::get('/kvadratnye-i-pryamougolnye', [PotController::class, 'square_rectangular_pots'])->name('square_rectangular_pots')`.
- [X] T005 [P] [US1] `routes/breadcrumbs.php`: вместо `rectangular_pots` и `square_pots` — `square_rectangular_pots`, родитель `pots`, текст «Квадратные и прямоугольные кашпо».
- [X] T006 [US1] `app/Http/Controllers/PotController.php`:
  - `rectangular_pots()` переименовать в `square_rectangular_pots()`;
  - в нём ключ страницы `square_rectangular_pots`, коллекция `Square_rectangular`, шаблон `elitvid.site.pots.square_rectangular_pots`;
  - метод `square_pots()` удалить.
- [X] T007 [US1] Шаблоны страницы:
  - `git mv resources/views/elitvid/site/pots/rectangular_pots.blade.php resources/views/elitvid/site/pots/square_rectangular_pots.blade.php`;
  - в новом файле `<h1>` → «Квадратные и прямоугольные <br>кашпо», сегмент в `show_pot_product` → `kvadratnye-i-pryamougolnye`;
  - вводный текст и картинку `rectangular_pots.webp` оставить (FR-008 — «Прямоугольные»);
  - удалить `resources/views/elitvid/site/pots/square_pots.blade.php`.
- [X] T008 [P] [US1] `resources/views/elitvid/site/pots.blade.php`, блок «Формы»:
  - вместо двух плиток «Квадратные» и «Прямоугольные» одна;
  - картинка `pots/forms/square_pot.webp` и её alt (FR-009);
  - `title="Квадратные и прямоугольные"`, `:href="route('square_rectangular_pots')"`;
  - текст из плитки «Прямоугольные»;
  - удалить комментарий `shortcut` про FR-002.
- [X] T009 [P] [US1] `resources/views/elitvid/site/pots/pot_product_page.blade.php`, строки 33–49:
  - в ветках `Square` и `Rectangular` ссылки на направление заменить одной веткой `Square_rectangular` → `route('square_rectangular_pots')`, «Квадратные и прямоугольные кашпо»;
  - ветку `Round` не трогать.

## Phase 3: User Story 2 — старые адреса не теряются (P1)

**Goal**: старые адреса страниц и товаров отвечают 301 на новые, sitemap отдаёт только новые.

**Independent test**: [quickstart](quickstart.md), пп. 4–5.

- [X] T010 [US2] Тесты в `tests/Feature/SquareRectangularPotsTest.php`:
  - `/napravleniya/kashpo/kvadratnye` и `/napravleniya/kashpo/pryamougolnye` → 301 на `route('square_rectangular_pots')`;
  - `/napravleniya/kashpo/kvadratnye/cube` и `/napravleniya/kashpo/pryamougolnye/box` → 301 на `route('show_pot_product', ['collection' => 'kvadratnye-i-pryamougolnye', 'slug' => …])`;
  - `/sitemap.xml` содержит `kvadratnye-i-pryamougolnye` и не содержит `/kashpo/kvadratnye<` и `/kashpo/kvadratnye/`.
- [X] T011 [US2] `routes/web.php`, группа `kashpo`, до `/{collection}/{slug}`: четыре `Route::permanentRedirect` по [contracts/routes.md](contracts/routes.md). Адрес назначения товара — `/napravleniya/kashpo/kvadratnye-i-pryamougolnye/{slug}`.
- [X] T012 [P] [US2] `app/Http/Controllers/SitemapController.php`: блоки `route('rectangular_pots')` и `route('square_pots')` заменить одним `route('square_rectangular_pots')` с теми же `changefreq` и `priority`. Товары берут сегмент из конфига (T002) и правок не требуют.

## Phase 4: User Story 3 — один пункт в админке (P2)

**Goal**: в админке одно направление: один список, один вариант в формах, одни картинки страницы.

**Independent test**: [quickstart](quickstart.md), п. 6.

- [X] T013 [US3] `routes/web.php`, админ-группа `pots`: вместо `admin_rectangular_pots` и `admin_square_pots` — `Route::get('/square_rectangular_pots', [AdminPotController::class, 'square_rectangular_pots'])->name('admin_square_rectangular_pots')`.
- [X] T014 [US3] `app/Http/Controllers/Admin/PotController.php`:
  - `rectangular_pots()` → `square_rectangular_pots()`, `getPots('Square_rectangular')`, шаблон `elitvid.admin.pots.pots_square_rectangular`;
  - `square_pots()` удалить.
- [X] T015 [US3] Шаблоны списка в админке:
  - `git mv resources/views/elitvid/admin/pots/pots_rectangular.blade.php resources/views/elitvid/admin/pots/pots_square_rectangular.blade.php`;
  - заголовки → «Список квадратных и прямоугольных кашпо» и «Квадратные и прямоугольные кашпо»;
  - удалить `resources/views/elitvid/admin/pots/pots_square.blade.php`.
- [X] T016 [P] [US3] `app/Helpers/ProductRouteCreatingHelper.php`: пары `Square` и `Rectangular` заменить на `'Square_rectangular' => route('admin_square_rectangular_pots')`.
- [X] T017 [P] [US3] Формы `resources/views/includes/elitvid/admin/create_pot_form.blade.php` и `update_pot_form.blade.php`:
  - варианты `Square` и `Rectangular` заменить одним `<option value="Square_rectangular">Квадратные и прямоугольные кашпо</option>`;
  - условие `selected` — по образцу соседних вариантов.
- [X] T018 [P] [US3] `resources/views/layouts/elitvid/admin/admin.blade.php`:
  - в обоих блоках меню товаров (строки 127–128 и 695–696) вместо двух пунктов — `route('admin_square_rectangular_pots')`, «Квадратные и прямоугольные кашпо»;
  - в обоих блоках картинок страниц (строки 169/171 и 737/739) вместо двух пунктов — `['page' => 'square_rectangular_pots']`, то же название.

## Phase 5: Polish

- [X] T019 `grep -rn "square_pots\|rectangular_pots\|'Square'\|'Rectangular'" app routes resources/views config`. Остаться могут только `admin/pots/pots.blade.php` (не рендерится, по плану не трогаем) и текст миграции.
- [X] T020 Применить миграцию: `docker compose exec php-fpm php artisan migrate`. Прогнать `./vendor/bin/phpunit` (с разрешения пользователя) и [quickstart](quickstart.md) целиком, включая откат и повторный `migrate`.
- [X] T021 Пересобрать граф: из корня `Elitvid_v2` выполнить `graphify extract . --code-only --out docs/ai` и `graphify cluster-only docs/ai --no-viz --no-label`.

## Dependencies

- T001 и T002 блокируют все истории.
- US1 (T004–T009) идёт до US2: перенаправления ведут на маршрут `square_rectangular_pots`.
- US3 зависит только от Phase 1.
- Тесты (T003, T010) пишутся первыми в своей фазе и падают до реализации.

## Parallel

- Phase 1: T002 параллельно с T001.
- US1: T005, T008, T009 параллельно после T004.
- US3: T016, T017, T018 параллельно.

## Implementation Strategy

MVP — Phase 1 + US1 + US2. Обе истории P1, и без перенаправлений старые адреса страниц отдадут 404, поэтому выкатывать их вместе. US3 доводит админку. Без неё после миграции списки `Square`/`Rectangular` пустые, а `ProductRouteCreatingHelper` не знает `Square_rectangular` (ошибка после сохранения товара). Поэтому для выкладки US3 тоже обязательна. Итог: всё одной поставкой.
