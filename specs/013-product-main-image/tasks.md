# Tasks: Главная картинка товара

**Input**: Design documents from `/specs/013-product-main-image/`

**Prerequisites**: plan.md, spec.md, research.md, data-model.md, contracts/admin-forms.md, quickstart.md

**Tests**: один feature-тест на правило главной картинки и снятие флага (нетривиальная логика).

## Phase 1: Setup

Нет: стек и структура уже есть.

## Phase 2: Foundational

- [X] T001 Добавить в `app/Models/Product.php` метод `mainImage(): ?Image` — `images` с `main_image = 1`, иначе картинка с наименьшим `id`, иначе `null` (работает по загруженной связи `images`)
- [X] T002 В `app/Services/ImageService.php` после создания картинки (`save`) и после правки (`update`): если `imageable_type` — `Product` и `main_image` истинно, у остальных картинок того же товара выставить `main_image = 0`. Блог и статические страницы не затрагивать

## Phase 3: User Story 1 — администратор выбирает главную (P1)

**Independent Test**: отметить другую картинку, сохранить, в форме отмечена только она.

- [X] T003 [US1] В `app/Http/Requests/UpdateImageRequest.php` правило `'main_image' => 'sometimes|boolean'`
- [X] T004 [US1] В `resources/views/includes/elitvid/admin/update_product.blade.php` в форму каждой существующей картинки: скрытое `main_image=0` и чекбокс `main_image=1` «Сделать главной», отмечен, если `$product->mainImage()?->id === $image->id`
- [X] T005 [P] [US1] В превью загрузки `public/elitvid_assets/newDesign/newDesign/js/create_pot_product.js` и `update_pot_product.js`: чекбокс `image_data[i][main_image]` value `1`, взаимоисключающий внутри контейнера превью, состояние сохраняется при пересоздании превью
- [X] T006 [P] [US1] То же в `public/elitvid_assets/newDesign/newDesign/js/create_bench_product.js` и `update_bench_product.js`
- [X] T007 [US1] Тест `tests/Feature/ProductMainImageTest.php`: правило `mainImage()` (отмеченная / первая / одна) и снятие флага с остальных при отметке

## Phase 4: User Story 2 — посетитель видит главную (P1)

**Independent Test**: главная не первая — карточка, «похожие» и страница товара показывают её.

- [X] T008 [P] [US2] Заменить `$product->images->first()` на `$product->mainImage()` в `resources/views/components/elitvid/collection-page.blade.php`, `resources/views/elitvid/site/urns.blade.php`, `resources/views/elitvid/site/pots/square_rectangular_pots.blade.php`
- [X] T009 [US2] В `resources/views/elitvid/site/pots/pot_product_page.blade.php`, `benches/bench_product_page.blade.php`, `urns/urn_product_page.blade.php`: `$firstImage = $product->mainImage()`, у `#first_image` атрибуты `data-color` и `data-texture`; в блоке «похожие» `$rand_product->images->first()` → `$rand_product->mainImage()`
- [X] T010 [US2] В `public/elitvid_assets/newDesign/newDesign/js/imageUpdater.js` начальные `currentTexture`/`currentColor` из `data-texture`/`data-color` у `#first_image`, при пустых — `marble` / `ivory`

## Phase 5: User Story 3 — главная у заполненных товаров (P2)

**Independent Test**: после миграции у каждого кашпо отмечена пористая «слоновая кость».

- [X] T011 [US3] Миграция данных `database/migrations/2026_11_26_000000_set_product_main_images.php`: у товаров (`imageable_type = App\Models\Product`) картинка `color = ivory`, `texture = porous` с наименьшим `id` → `main_image = 1`, остальные картинки этого товара → `0`; `down` снимает `main_image` у картинок товаров
- [X] T012 [US3] Выполнить миграцию на `elitvid_db`, проверить SELECT: 27 кашпо с одной отмеченной пористой ivory

## Phase 6: Polish

- [X] T013 Пройти `quickstart.md` на http://localhost:8080
- [X] T014 Пересобрать граф `docs/ai/graphify-out/`; обновить `docs/ai/SERVICE_MAP.md` и `docs/human/katalog.md` про главную картинку

## Dependencies

- T001, T002 → все истории. US1, US2, US3 независимы друг от друга после Phase 2.
- T013 после всех; T014 последним.

## Parallel

- T005 и T006 (разные файлы); T008 параллельно с T009.

## Implementation Strategy

MVP — Phase 2 + US1 + US2; затем US3 (данные), затем проверка и документация.
