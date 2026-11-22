# Implementation Plan: Правки готовых страниц редизайна

**Branch**: `004-redesign-fixes` | **Date**: 2026-11-21 | **Spec**: [spec.md](spec.md)

**Input**: Feature specification from `specs/004-redesign-fixes/spec.md`

## Summary

Довести главную, «Каталог», «Блог», шапку, подвал и окно заявки до кадров «ребрендинг» на 1440 и 320 px. Это правки вёрстки и стилей поверх того, что собрала спека 001: Blade-компоненты `components/elitvid/*`, шаблоны страниц и `public/elitvid_assets/redesign/redesign.css`. Серверный код, маршруты, форма заявки и база не меняются.

## Technical Context

**Language/Version**: PHP 8.5, Laravel 13, Blade

**Primary Dependencies**: jQuery 3.7, Swiper (уже подключены). Новых библиотек нет.

**Storage**: не меняется. Картинки нового вида — файлы в `public/elitvid_assets/redesign/images/` (в git, как у 001).

**Testing**: фронтовых тестов нет. Проверка — `quickstart.md` на 1440 и 320 px, сравнение с PNG-кадрами.

**Target Platform**: публичный сайт, http://localhost:8080

**Project Type**: web (серверный рендер)

**Performance Goals**: новые картинки в webp, не тяжелее существующих в `redesign/images/`.

**Constraints**: без горизонтальной прокрутки на 320 px; при правке `redesign.css` поднять `?v=` в `layouts/elitvid/elitvid.blade.php`.

**Scale/Scope**: 3 страницы и 3 общих компонента.

## Constitution Check

`.specify/memory/constitution.md` — пустой шаблон, действуют правила `AGENTS.md` и `resources/views/AGENTS.md`:

- Ссылки через `route()`, новых маршрутов нет — PASS.
- Форма заявки: поля и `send_mail` не меняются, меняется только вид — PASS.
- Повторяемые части в `components/elitvid/` — правки идут в существующие компоненты — PASS.
- Текст, который редактируется в админке, не хардкодить — тексты страниц не меняются; заголовок «БОЛЬШЕ ПРИМЕРОВ» проверить в `pageContent` перед правкой (research R4) — PASS при условии R4.
- `?v=` у CSS поднимается — PASS.
- Вид админки не меняется — PASS.

## Project Structure

### Documentation (this feature)

```text
specs/004-redesign-fixes/
├── plan.md
├── research.md
├── quickstart.md
└── checklists/requirements.md
```

`data-model.md` и `contracts/` не нужны: данных и интерфейсов фича не меняет. Контракт формы остаётся `specs/001-public-site-redesign/contracts/request-form.md`.

### Source Code (repository root)

```text
resources/views/
├── components/elitvid/header.blade.php      # телефоны (FR-004)
├── components/elitvid/footer.blade.php      # телефоны, вёрстка подвала
├── components/elitvid/blog-card.blade.php   # выравнивание кнопок
├── includes/elitvid/redesign-directions.blade.php  # «звезда», фото парклетов
├── includes/elitvid/popup_application.blade.php    # вид окна заявки (если классы нужны)
├── elitvid/site/index.blade.php             # первый экран, «Почему», орнамент, «Больше примеров»
├── elitvid/site/directions.blade.php        # фон первого экрана
├── elitvid/site/blog/blog.blade.php         # фон первого экрана
└── layouts/elitvid/elitvid.blade.php        # ?v= у redesign.css

public/elitvid_assets/redesign/
├── redesign.css
└── images/  star.webp, parklets.webp (замена), ornament.webp (прозрачный фон), catalog-hero.webp, blog-hero.webp
```

**Structure Decision**: только существующие файлы редизайна плюс новые картинки в `redesign/images/`.

## Complexity Tracking

Нарушений нет.
