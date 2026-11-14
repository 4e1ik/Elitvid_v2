---

description: "Task list template for feature implementation"
---

# Tasks: Публичный редизайн

**Input**: Design documents from `/specs/001-public-site-redesign/`

**Prerequisites**: plan.md, spec.md, research.md, data-model.md, contracts/

**Tests**: Не запрошены. Отдельные тестовые задачи не создаются. Проверка — `quickstart.md`.

**Organization**: Задачи сгруппированы по пользовательским историям.

## Format: `[ID] [P?] [Story] Description`

- **[P]**: можно делать параллельно (другие файлы, нет зависимости от незавершённых задач)
- **[Story]**: история, к которой относится задача
- В каждой задаче указан путь к файлу

## Phase 1: Setup (Shared Infrastructure)

**Purpose**: Каталоги нового вида рядом со старым CSS

- [x] T001 Создать каталоги `public/elitvid_assets/redesign/` и `resources/views/components/elitvid/`
- [x] T002 [P] Создать `public/elitvid_assets/redesign/redesign.css`, подключить уже лежащие `public/elitvid_assets/newDesign/newDesign/fonts/Montserrat-Regular.woff2`, `Montserrat-Medium.woff2` и `Montserrat-SemiBold.woff2`, не переопределяя классы старого тела страницы
- [x] T003 [P] Создать `public/elitvid_assets/redesign/redesign.js` только для открытия мобильного меню, списка контактов и формы заявки

---

## Phase 2: Foundational (Blocking Prerequisites)

**Purpose**: Общие части, без которых нельзя собрать ни одну историю

**⚠️ CRITICAL**: Истории не начинать, пока эта фаза не закончена

- [x] T004 Создать кнопку широкого и узкого вида в `resources/views/components/elitvid/button.blade.php`
- [x] T005 Создать шапку в `resources/views/components/elitvid/header.blade.php` с пунктами «Главная», «Каталог», «Блог», «Контакты», кнопкой «Корзина» без адреса и кнопкой «Оставить заявку»
- [x] T006 Создать подвал широкого и узкого вида в `resources/views/components/elitvid/footer.blade.php`
- [x] T007 Подключить `public/elitvid_assets/redesign/redesign.css` и `public/elitvid_assets/redesign/redesign.js` в `resources/views/layouts/elitvid/elitvid.blade.php`, заменить шапку и подвал компонентами и оставить ссылку на старый `public/elitvid_assets/newDesign/newDesign/style.css`

**Checkpoint**: Новый каркас есть на всех публичных страницах, старое тело ещё на месте

---

## Phase 3: User Story 1 - Новый вид трёх страниц (Priority: P1) 🎯 MVP

**Goal**: Главная, направления и список блога совпадают с кадрами «главная», «каталог» и «блог» на ширине 1440 и 320

**Independent Test**: Открыть три страницы на двух ширинах и сравнить расположение, тексты и картинки с кадрами страницы «ребрендинг»

### Implementation for User Story 1

- [x] T008 [P] [US1] Создать карточку направления в `resources/views/components/elitvid/direction-card.blade.php`
- [x] T009 [P] [US1] Создать карточку статьи в `resources/views/components/elitvid/blog-card.blade.php`, которая показывает текущие название, описание и картинку записи и ничего в неё не записывает
- [x] T010 [US1] Скачать картинки главной и страницы направлений из файла Figma `JO6HaDjZj7B9RgwmNe31ln`, кадр страницы `8:21536`, перевести в WebP и положить в уже существующий слот админки либо в `public/elitvid_assets/redesign/images/`
- [x] T011 [US1] Собрать главную в `resources/views/elitvid/site/index.blade.php` по кадру «главная»: карточки направлений и одноразовые блоки цифр, партнёров, видео и примеров работ
- [x] T012 [P] [US1] Собрать страницу направлений в `resources/views/elitvid/site/directions.blade.php` по кадру «каталог», оставив существующий адрес
- [x] T013 [P] [US1] Собрать список блога в `resources/views/elitvid/site/blog/blog.blade.php` по кадру «блог», выводя все активные записи и не изменяя таблицу `blogs`

**Checkpoint**: Три страницы можно сравнивать с макетом отдельно от остальных задач

---

## Phase 4: User Story 2 - Общая шапка и подвал (Priority: P2)

**Goal**: На страницах без макета новые только шапка и подвал. «Контакты» не создают адрес. «Корзина» ничего не делает

**Independent Test**: Открыть страницу товара и проверить новую шапку, старое описание, список контактов и пустое нажатие «Корзина»

### Implementation for User Story 2

- [x] T014 [US2] Записать в `resources/views/components/elitvid/header.blade.php` почту и телефоны из кадра контактов, не добавляя маршрут в `routes/web.php`
- [x] T015 [US2] Оставить «Корзину» кнопкой без обработчика в `resources/views/components/elitvid/header.blade.php` и не добавлять для неё действие в `public/elitvid_assets/redesign/redesign.js`
- [x] T016 [US2] Не менять тело `resources/views/elitvid/site/benches/bench_product_page.blade.php` и `resources/views/elitvid/site/pots/pot_product_page.blade.php`; если новый CSS задевает это тело, сузить правила в `public/elitvid_assets/redesign/redesign.css`

**Checkpoint**: Страница товара показывает новый каркас и прежнее тело

---

## Phase 5: User Story 3 - Заявка и содержимое (Priority: P3)

**Goal**: Форма выглядит по-новому и принимается по старым правилам. Тексты главной и направлений лежат в прежнем хранилище. Статьи не переписаны

**Independent Test**: Отправить допустимую и недопустимую заявку. Сверить название и картинку прежней статьи. Убедиться, что текст главной редактируется тем же способом, что раньше

### Implementation for User Story 3

- [x] T017 [P] [US3] Создать поле ввода в `resources/views/components/elitvid/input.blade.php`
- [x] T018 [US3] Переверстать `resources/views/includes/elitvid/popup_application.blade.php` новым видом, сохранив поля `name`, `email`, `phone`, `name_corp`, `textarea`, файл с пределом 512 КБ и `g-recaptcha-response`
- [x] T019 [US3] Не менять правила `app/Http/Requests/MailRequest.php`: обязательные имя, почта и телефон, телефонный шаблон `29`, `33`, `44`, `25` плюс 7 цифр либо `9` или `7` плюс 9 цифр, файл `max:512`, обязательная проверка «я не робот»
- [x] T020 [US3] Обновить тексты ключей `main` и `directions` в `page_contents` текстами кадра и не выполнять запись в таблицу `blogs`

**Checkpoint**: Заявка и статьи ведут себя как до редизайна

---

## Phase 6: Polish & Cross-Cutting Concerns

**Purpose**: Документация и общая проверка

- [x] T021 [P] Обновить описание публичного вида в `docs/human/obzor.md` и `docs/human/blog.md` по фактическому поведению
- [x] T022 Пройти сценарии `specs/001-public-site-redesign/quickstart.md` на http://localhost:8080

---

## Dependencies & Execution Order

### Phase Dependencies

- **Setup (Phase 1)**: сразу
- **Foundational (Phase 2)**: после Setup, блокирует все истории
- **User Stories (Phase 3–5)**: после Phase 2, по порядку P1 → P2 → P3
- **Polish (Phase 6)**: после нужных историй

### User Story Dependencies

- **User Story 1 (P1)**: после Phase 2, не зависит от US2 и US3
- **User Story 2 (P2)**: после Phase 2. Использует шапку из Phase 2 и не требует готовых трёх страниц для проверки страницы товара
- **User Story 3 (P3)**: после Phase 2. Форма не зависит от вида трёх страниц. Обновление `page_contents` лучше делать после T011, чтобы текст совпал с уже собранной главной

### Within Each User Story

- T008 и T009 параллельны
- T011 после T008 и T010
- T012 после T008
- T013 после T009
- T018 после T017
- T019 не меняет файл правил и идёт вместе с T018 как запрет на расширение полей

### Parallel Opportunities

- T002 и T003 параллельны
- T008 и T009 параллельны
- T012 и T013 параллельны после своих карточек
- T021 параллелен подготовке к ручной проверке, но T022 выполняется последним

---

## Parallel Example: User Story 1

```bash
Task: "Создать карточку направления в resources/views/components/elitvid/direction-card.blade.php"
Task: "Создать карточку статьи в resources/views/components/elitvid/blog-card.blade.php"
```

После карточек:

```bash
Task: "Собрать страницу направлений в resources/views/elitvid/site/directions.blade.php"
Task: "Собрать список блога в resources/views/elitvid/site/blog/blog.blade.php"
```

---

## Implementation Strategy

### MVP First (User Story 1 Only)

1. Закончить Phase 1 и Phase 2
2. Закончить Phase 3
3. Остановиться и сравнить три страницы с кадрами
4. Показывать этот результат можно до шапки на старых страницах и до правки заявки

### Incremental Delivery

1. Setup и Foundational дают общий каркас
2. User Story 1 даёт три новых страницы
3. User Story 2 проверяет старые страницы и пустую корзину
4. User Story 3 сохраняет правила заявки и тексты в прежнем месте
5. Phase 6 сверяет весь `quickstart.md` и обновляет документацию

### Parallel Team Strategy

После Phase 2 один человек собирает три страницы, второй ограничивает CSS на странице товара и список контактов. Форму лучше не начинать, пока поле ввода не создано.

---

## Notes

- [P] означает другие файлы и отсутствие зависимости от незавершённой задачи
- Автотесты не писать: в спецификации их нет
- Таблицу `blogs` не изменять
- Новые маршруты не добавлять
- Админский каркас `resources/views/layouts/elitvid/admin/` не менять
