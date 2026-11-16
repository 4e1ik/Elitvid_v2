# Tasks: Корзина и заявки

**Input**: Design documents from `/specs/002-user-cart/`

**Prerequisites**: plan.md, spec.md, research.md, data-model.md, contracts/

**Tests**: Автоматические тесты не запрошены. Проверка — сценарии из quickstart.md и запись заказа в `storage/logs/laravel.log`.

**Organization**: Задачи сгруппированы по пользовательским историям.

## Format: `[ID] [P?] [Story] Description`

## Phase 1: Setup

**Purpose**: Проект уже есть, новых библиотек нет.

- [x] T001 Подтвердить, что новые библиотеки не нужны, по `specs/002-user-cart/plan.md`

---

## Phase 2: Foundational

**Purpose**: Таблицы и модели, без которых заявку некуда сохранить.

- [x] T002 Создать таблицы `orders` и `order_items` в `database/migrations/2026_11_16_091600_create_orders_tables.php`. У заказа `name`, `email`, `phone`, необязательные `corporation_name` и `comment`. У строки `order_id`, необязательный `product_id`, `product_name` до 255 символов, `quantity` от 1
- [x] T003 [P] Создать модели `app/Models/Order.php` и `app/Models/OrderItem.php` со связью заказа и строк

**Checkpoint**: Миграция применяется на локальной базе.

---

## Phase 3: User Story 1 — Собрать корзину (Priority: P1)

**Goal**: Посетитель добавляет несколько товаров и открывает корзину из шапки.

**Independent Test**: Два товара видны на `/cart` после обновления страницы.

- [x] T004 [P] [US1] Принимать только активную скамейку или кашпо в `app/Http/Requests/AddToCartRequest.php`: `product_id` обязательный, товар `active`, `product_type` `bench` или `pot`
- [x] T005 [US1] Хранить словарь `product_id → quantity` в сессии в `app/Repositories/CartRepository.php` и добавлять товар в `app/Services/CartService.php`
- [x] T006 [US1] Открыть `GET /cart` и принять `POST /cart/items` в `app/Http/Controllers/CartController.php` и `routes/web.php`
- [x] T007 [P] [US1] Показать строки на `resources/views/elitvid/site/cart.blade.php`
- [x] T008 [P] [US1] Сделать «Корзина» ссылкой в `resources/views/components/elitvid/header.blade.php` и кнопку «В корзину» в `resources/views/elitvid/site/benches/bench_product_page.blade.php` и `resources/views/elitvid/site/pots/pot_product_page.blade.php`

**Checkpoint**: Корзина собирается без заявки.

---

## Phase 4: User Story 2 — Изменить корзину и отправить заявку (Priority: P1)

**Goal**: Количество, очистка и заявка с записью в журнал.

**Independent Test**: Верная заявка очищает корзину и оставляет читаемую строку в `storage/logs/laravel.log`.

- [x] T009 [P] [US2] Проверять количество 0–999 в `app/Http/Requests/UpdateCartRequest.php`
- [x] T010 [P] [US2] Проверять заявку в `app/Http/Requests/PlaceOrderRequest.php` и собирать `app/DTO/PlaceOrderData.php`. Имя и почта обязательны и не длиннее 50. Телефон обязателен и совпадает с правилом `MailRequest`. Организация не длиннее 50, комментарий не длиннее 100, оба можно не заполнять. Файл не принимается. `g-recaptcha-response` обязателен и проверяется тем же запросом к Google
- [x] T011 [US2] Менять количество, очищать корзину и сохранять заказ в `app/Services/CartService.php` и `app/Repositories/OrderRepository.php`. Письмо не отправлять. В журнал писать номер, контакты и товары
- [x] T012 [US2] Принять `POST /cart/items/{product}`, `POST /cart/clear` и `POST /cart/order` в `app/Http/Controllers/CartController.php` и `routes/web.php`
- [x] T013 [US2] Добавить количество, очистку и форму заявки на `resources/views/elitvid/site/cart.blade.php`. Кнопка формы получает токен reCAPTCHA так же, как окно заявки

**Checkpoint**: Заявка создаётся и видна в журнале.

---

## Phase 5: User Story 3 — Список заказов (Priority: P2)

**Goal**: Админка показывает все заказы, фильтр по дате и CSV.

**Independent Test**: Фильтр оставляет заказы выбранных дней, CSV содержит всю выборку, одна строка на заказ.

- [x] T014 [P] [US3] Принять `date_from` и `date_to` как день `Y-m-d` либо пустое значение в `app/Http/Requests/OrderFilterRequest.php` и `app/DTO/OrderFilterData.php`
- [x] T015 [US3] Отдавать 20 заказов на страницу и весь фильтр для CSV из `app/Repositories/OrderRepository.php` и `app/Services/Admin/OrderService.php`. Столбцы: Дата, Имя, Почта, Телефон, Организация, Комментарий, Товары. Товары в одном столбце как `Название × количество`
- [x] T016 [US3] Открыть `GET /admin/orders` и `GET /admin/orders/export` для ролей `admin` и `manager` в `app/Http/Controllers/Admin/OrderController.php` и `routes/web.php`
- [x] T017 [P] [US3] Показать список, фильтр и ссылку на CSV в `resources/views/elitvid/admin/orders/index.blade.php` и пункт «Заказы» в `resources/views/layouts/elitvid/admin/admin.blade.php`

**Checkpoint**: Список, фильтр и файл работают.

---

## Phase 6: Polish

- [x] T018 Пройти сценарии из `specs/002-user-cart/quickstart.md` и оставить запись заказа в `storage/logs/laravel.log`

---

## Dependencies & Execution Order

### Phase Dependencies

- Setup ни от чего не зависит.
- Foundational блокирует истории.
- User Story 2 использует корзину из User Story 1.
- User Story 3 читает заказы, которые создаёт User Story 2.
- Polish идёт последним.

### User Story Dependencies

- **User Story 1 (P1)**: после Phase 2.
- **User Story 2 (P1)**: после User Story 1, потому что заявка отправляет собранную корзину.
- **User Story 3 (P2)**: после User Story 2, потому что список показывает сохранённые заказы.

### Parallel Opportunities

- T003 можно писать одновременно с T002 до запуска миграции.
- T004, T007 и T008 не зависят друг от друга до подключения маршрутов.
- T009 и T010 не зависят друг от друга.
- T014 и вёрстка T017 можно готовить параллельно с запросом T015.

## Parallel Example: User Story 1

```bash
Task: "AddToCartRequest в app/Http/Requests/AddToCartRequest.php"
Task: "Страница resources/views/elitvid/site/cart.blade.php"
Task: "Кнопка в шапке и на страницах товара"
```

## Implementation Strategy

### MVP First (User Story 1 Only)

1. Phase 1 и Phase 2.
2. User Story 1.
3. Проверить, что два товара остаются в корзине.

### Incremental Delivery

1. Корзина.
2. Заявка и журнал.
3. Админка и CSV.
4. Сценарий quickstart.

## Notes

- Методы сервиса и репозитория, нужные одному-единственному месту внутри того же класса, не выделять.
- Общий запрос фильтра используется и списком, и CSV.
- Письмо не отправляется.
