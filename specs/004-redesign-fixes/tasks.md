# Tasks: Правки готовых страниц редизайна

**Input**: `specs/004-redesign-fixes/` (spec, plan, research, quickstart)

## Phase 1: Setup

- [x] T001 Положить картинки в `public/elitvid_assets/redesign/images/`: `star.webp` (из кадра), `parklets.webp` (из `Парклет.png`), `ornament.webp` (прозрачный фон)
- [x] T002 Положить `catalog-hero.webp` и `blog-hero.webp` после экспорта слоёв `image 64` и `image 66` (ждёт пользователя)

## Phase 2: User Story 1 — шапка, подвал, окно заявки (P1)

- [x] T003 [US1] Меню шапки по кадру в `public/elitvid_assets/redesign/redesign.css`
- [x] T004 [US1] Панель «Контакты»: тёмная подложка, скругление, рамка в `redesign.css`
- [x] T005 [US1] Подвал: линия на всю ширину, колонки и отступы в `redesign.css`
- [x] T006 [US1] Телефоны по FR-004 в `resources/views/components/elitvid/header.blade.php` и `footer.blade.php` (ждёт ответа)
- [x] T007 [US1] Окно заявки: зелёная рамка, зелёная кнопка, размер подписи в `redesign.css`

## Phase 3: User Story 2 — главная (P2)

- [x] T008 [US2] Первый экран: высота и перенос заголовка в `resources/views/elitvid/site/index.blade.php` и `redesign.css`
- [x] T009 [US2] «Звезда» и слоган в `resources/views/includes/elitvid/redesign-directions.blade.php` и `redesign.css`
- [x] T010 [US2] Подписи кнопок карточек medium в `redesign.css`
- [x] T011 [US2] Маркеры в «Почему выбирают» в `redesign.css`
- [x] T012 [US2] Блок нанесения логотипов: ширина заголовка и кнопки в `redesign.css`
- [x] T013 [US2] Заголовок «Больше примеров» в `index.blade.php`

## Phase 4: User Story 3 — каталог и блог (P3)

- [x] T014 [US3] Фон первого экрана и заголовок в 2 строки в `resources/views/elitvid/site/directions.blade.php`, `resources/views/elitvid/site/blog/blog.blade.php`, `redesign.css`
- [x] T015 [US3] Карточки блога: кнопки на одной линии, высота картинок в `resources/views/components/elitvid/blog-card.blade.php` и `redesign.css`

## Phase 5: Узкий экран и проверка

- [x] T016 Сверить 320 по кадрам и поправить `redesign.css` (FR-018), меню не трогать (FR-019)
- [x] T017 Поднять `?v=` у `redesign.css` в `resources/views/layouts/elitvid/elitvid.blade.php`
- [ ] T018 Пройти `quickstart.md` на 1440 и 320 — пройдено всё, кроме отправки заявки (шаг 5): reCAPTCHA, отправляет пользователь
- [x] T020 Плавный выезд «Контактов» и мобильного меню (FR-020) в `redesign.css`, `redesign.js`; мобильное меню — панель поверх контента (FR-021)
- [x] T021 Лента партнёров снова слайдер с автопрокруткой; hover в шапке и у «Скачать каталог»; мобильные фото из кадров 320 (FR-016, FR-022, FR-023)
- [x] T022 Вид выбора кода страны по кадру (FR-024): `popup_application.blade.php`, `cart.blade.php`, `redesign.js`, `redesign.css`
- [x] T019 Пересобрать граф `docs/ai/graphify-out/`
