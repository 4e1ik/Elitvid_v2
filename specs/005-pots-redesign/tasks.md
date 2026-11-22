# Tasks: Кашпо в новом виде

## Phase 1: Общее

- [x] T001 Крошки нового вида: `components/elitvid/breadcrumbs.blade.php`, названия «Каталог» и «Вазоны и кашпо» в `routes/breadcrumbs.php`
- [x] T002 Фон первого экрана «Круглые кашпо» (`image 68`) в `public/elitvid_assets/redesign/images/` (ждёт экспорта)

## Phase 2: US1 — страницы (P1)

- [x] T003 [US1] «Вазоны и кашпо» в новом виде: `elitvid/site/pots.blade.php`, `components/elitvid/form-row.blade.php`, `redesign.css` (блок «Формы» пока с прежними тремя формами — T004)
- [ ] T004 [US1] Блок «Формы»: две формы (ждёт адреса объединённой страницы, FR-002)
- [x] T005 [US1] «Круглые кашпо» в новом виде: `elitvid/site/pots/round_pots.blade.php`, `redesign.css`

## Phase 3: US2 — состав (P2)

- [x] T006 [US2] Выключить в админке ROUND COLOMN, BEVEL, BOCHKA; записать в список для прода
- [ ] T007 [US2] Завести SPHERE, BEVEL CYLINDER, CAPSULE (ждёт фото, US3 сц. 5)
- [ ] T008 [US2] Объединённая страница, классическое кашпо, дикий камень (ждёт FR-002, FR-005)

## Phase 4: US3 — карточка (P3)

- [x] T009 [US3] Фактуры «Мрамор», «Пористая»; 8 цветов из ТЗ без «шоколада» в `pot_product_page.blade.php`
- [x] T010 [US3] Признак «в корзине» с бэкенда, кнопки «Добавить в корзину» / «Удалить»
- [ ] T011 [US3] Цвет «шоколад» (ждёт образца и фото)

## Phase 4b: Корзина без количества

- [x] T013 `CartService::add` кладёт товар один раз, в заявку пишется 1; «Удалить» вместо «− N +» в `elitvid/site/cart.blade.php`
- [x] T014 Без «× N» в `Services/Admin/OrderService.php` (CSV), `elitvid/admin/orders/index.blade.php`, журнале `CartService::place`
- [x] T015 Тесты `tests/Feature/CartOrderTest.php`

## Phase 5: Проверка

- [ ] T012 `quickstart.md` на 1440 и 320, `?v=` у CSS/JS, граф
