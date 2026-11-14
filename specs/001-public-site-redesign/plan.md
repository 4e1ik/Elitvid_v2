# Implementation Plan: Публичный редизайн

**Branch**: `001-public-site-redesign` | **Date**: 2026-11-14 | **Spec**: [spec.md](spec.md)

**Input**: Feature specification from `/specs/001-public-site-redesign/spec.md`

## Summary

Три публичные страницы — главная, направления и список блога — получают вид кадров «ребрендинг». Шапка и подвал из этих кадров встают в общий каркас, поэтому они появляются на всех публичных страницах, а тело остальных страниц не переписывается. Повторяемые части становятся Blade-компонентами. Новый вид описывается отдельным CSS. Скрипт нужен только для меню, списка контактов и формы. Заявка остаётся прежним `POST`-запросом. Записи блога не изменяются.

## Technical Context

**Language/Version**: PHP 8.1, Laravel 10, Blade

**Primary Dependencies**: существующий сайт без нового сборщика и без новых библиотек интерфейса. Шрифт Montserrat уже подключён файлами woff2.

**Storage**: MariaDB `elitvid_db` для текстов страниц, картинок слотов и статей. Файлы картинок, которых нет в админке, лежат в `public/`. Новых таблиц нет.

**Testing**: ручная проверка по [quickstart.md](quickstart.md) на http://localhost:8080. Отдельного набора автоматических тестов у публичных страниц сейчас нет, и этот план его не заводит.

**Target Platform**: локальный Docker-сайт, браузер на широком (1440) и узком (320) экране.

**Project Type**: серверный сайт с шаблонами Blade.

**Performance Goals**: три новые страницы не подключают слайдер и не добавляют библиотек. Картинки из макета сохраняются в WebP. Существующие скрипты старых страниц не раздуваются новыми файлами.

**Constraints**: CSS описывает вид. Скрипт только открывает мобильное меню, контакты и форму. «Корзина» не имеет обработчика. Вид админки не меняется. Тексты и картинки главной и направлений обновляются там, где они уже хранятся. Статьи блога не правятся.

**Scale/Scope**: 3 страницы целиком, общий каркас на остальных публичных страницах, 7 повторяемых частей.

## Constitution Check

*GATE: Must pass before Phase 0 research. Re-check after Phase 1 design.*

`.specify/memory/constitution.md` всё ещё шаблон без принципов. Проверяемых запретов нет, нарушений нет.

Повторная проверка после Phase 1: новых таблиц, адресов и зависимостей не добавлено. Ворота по-прежнему пустые и пройдены.

## Project Structure

### Documentation (this feature)

```text
specs/001-public-site-redesign/
├── plan.md
├── research.md
├── data-model.md
├── quickstart.md
├── contracts/
│   ├── public-pages.md
│   └── request-form.md
└── tasks.md              # появится на /speckit-tasks
```

### Source Code (repository root)

```text
resources/views/layouts/elitvid/elitvid.blade.php
resources/views/components/elitvid/
resources/views/elitvid/site/index.blade.php
resources/views/elitvid/site/directions.blade.php
resources/views/elitvid/site/blog/blog.blade.php
resources/views/includes/elitvid/popup_application.blade.php
public/elitvid_assets/redesign/
```

Остальные шаблоны `resources/views/elitvid/site/` сохраняют тело страницы и получают шапку с подвалом через общий каркас. Админский каркас `resources/views/layouts/elitvid/admin/` не меняется.

**Structure Decision**: один Laravel-проект. Новые компоненты лежат в `resources/views/components/elitvid/`, чтобы не смешаться с компонентами входа Breeze. Новый CSS и маленький скрипт лежат в `public/elitvid_assets/redesign/`. Старый `style.css` остаётся для тел страниц без макета.

## Complexity Tracking

Нарушений конституции нет. Отдельное обоснование не требуется.
