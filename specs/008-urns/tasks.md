# Tasks: Урны

**Input**: [spec.md](spec.md), [plan.md](plan.md), [research.md](research.md), [data-model.md](data-model.md), [contracts/routes.md](contracts/routes.md), [quickstart.md](quickstart.md)

Тест `tests/Feature/UrnPagesTest.php` — одна проверка новой логики (тип товара, корзина, 404); запуск — с разрешения пользователя.

## Phase 1: Setup

- [X] T001 Сделать `public/elitvid_assets/redesign/images/urns-hero.webp` из `~/Downloads/urni/image 89.png` (ширина 2682, webp)

## Phase 2: Foundational

- [X] T002 Миграция `database/migrations/2026_11_25_100000_create_urns_table.php`: `urns` — `id`, `product_id` FK `products.id` `onDelete cascade` + индекс, `data` json nullable, `material` string(255) nullable, timestamps
- [X] T003 [P] Модель `app/Models/Urn.php` (fillable `product_id`, `data`, `material`; cast `data` → array) и связь `urn()` hasOne в `app/Models/Product.php`
- [X] T004 Ветка `urn` в `app/Services/Admin/ProductService.php` (store: `Urn::create`, update: `$product->urn->update`)
- [X] T005 [P] `app/Http/Requests/CreateProductRequest.php` и `UpdateProductRequest.php`: `product_type` `in:pot,bench,urn`; `collection` — `required_if:product_type,pot,bench` (у урны нет); фото урны как у кашпо — «хотя бы одно изображение»
- [X] T006 [P] `app/Http/Requests/AddToCartRequest.php` и `app/Services/CartService.php`: `urn` в списке доступных типов
- [X] T007 Применить миграции в контейнере (`php artisan migrate`)

## Phase 3: User Story 1 — страница «Урны» (P1)

**Independent test**: quickstart пп. 1–3.

- [X] T008 [US1] `app/Repositories/UrnRepository.php`: активные урны (`latest()`), урна по slug среди `urn`, урны для «Другие формы» (`inRandomOrder()`)
- [X] T009 [US1] `app/Http/Controllers/UrnController.php::urns` + маршрут `GET /napravleniya/urny` `urns` в `routes/web.php` (до `/{slug}`) + крошка `urns` (parent `directions`, «Урны») в `routes/breadcrumbs.php`
- [X] T010 [US1] Вьюха `resources/views/elitvid/site/urns.blade.php`: `rd-hero rd-hero--crumbs rd-hero--urns`, заголовок «Урны из полистоуна», текст кадра, «Оставить заявку»; `rd-grid` из `x-elitvid.direction-card`; SEO-текст и `x-elitvid.works` как в `pots.blade.php`
- [X] T011 [P] [US1] `public/elitvid_assets/redesign/redesign.css`: `rd-hero--urns` (десктоп и мобильный `rd-hero__photo`) в тех же группах, что `rd-hero--round`
- [X] T012 [P] [US1] `config/pages.php` `'urns' => 'Урны'` + миграция `database/migrations/2026_11_25_100001_add_urns_page_content.php` (как спека 007)

## Phase 4: User Story 2 — страница урны (P2)

**Independent test**: quickstart пп. 4–7.

- [X] T013 [US2] `UrnController::show_urn_product` + маршрут `GET /napravleniya/urny/{slug}` `show_urn_product`; нет урны → 404
- [X] T014 [US2] Вьюха `resources/views/elitvid/site/urns/urn_product_page.blade.php`: копия `pots/pot_product_page.blade.php` с `->urn`, крошками «Главная › Наши направления › Урны › {название}», ссылками «Другие формы» на `show_urn_product`

## Phase 5: User Story 3 — админка (P3)

**Independent test**: quickstart пп. 9–10.

- [X] T015 [US3] `app/Repositories/Admin/UrnRepository.php` (все урны, `latest()`) + `app/Http/Controllers/Admin/UrnController.php::index` + маршрут `GET /admin/urns` `admin_urns` в группе чтения
- [X] T016 [US3] Вьюха `resources/views/elitvid/admin/urns/urns.blade.php`: копия `pots/pots_round.blade.php` с `->urn`, заголовки «Урны», кнопка «Добавить товар» → `create`, `route=urns`
- [X] T017 [US3] `AdminController::create('urns')` → `productType = 'urn'`; `ProductController::edit` грузит `urn`; `ProductRouteCreatingHelper`: `urn` → `admin_urns`
- [X] T018 [US3] `create_product.blade.php`/`update_product.blade.php`: урна как кашпо (несколько фото, цвет/фактура, заголовок «урны», JS кашпо); `create_urn_form`/`update_urn_form` подключают формы кашпо; в формах кашпо блок «Форма» только для `pot`, данные из `$product->{$productType}`
- [X] T019 [US3] Пункт «Урны» в левом и мобильном меню `resources/views/layouts/elitvid/admin/admin.blade.php`

## Phase 6: User Story 4 — входы (P4)

- [X] T020 [P] [US4] `resources/views/includes/elitvid/redesign-directions.blade.php`: плитка «Урны» → `route('urns')`
- [X] T021 [P] [US4] `resources/views/components/elitvid/footer.blade.php`: оба «Урны» → ссылки на `route('urns')`

## Phase 7: Polish

- [X] T022 [P] `app/Http/Controllers/SitemapController.php`: `urns` и активные урны (FR-013)
- [X] T023 [P] `tests/Feature/UrnPagesTest.php`: список показывает только активные урны; карточка 200; slug кашпо → 404; урна добавляется в корзину
- [X] T024 Завести 5 урн через админку (MONRO, ORION, VEKTOR, TITAN, SKANDI — в этом порядке), материал «полимербетон», размеры из ТЗ, вес и цена пустые, фото без цвета/фактуры; записать в `../admin-changes-prod.md` и файлы в `../prod-uploads/urns/`
- [X] T025 Пройти `quickstart.md`, запустить `phpunit` (с разрешения), пересобрать граф

## Dependencies

T001–T007 → US1 → US2 (нужен маршрут списка для крошек) → US3 → T024. US4, T022, T023 — после T009/T013.

## Implementation Strategy

MVP — US1 + US2 (сайт), затем админка и заведение урн.

- [X] T027 «Другие формы» в карточке урны: фото в одной рамке 4:3 (`offered_products--urns` в `redesign.css`), `?v=3.7`
- [X] T028 «от» только при заполненной цене в карточках кашпо, скамей и урн (FR-014)
