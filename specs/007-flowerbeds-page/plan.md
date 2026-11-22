# Implementation Plan: Страница «Сборные клумбы»

**Branch**: `007-flowerbeds-page` | **Spec**: [spec.md](spec.md)

## Summary

Новый маршрут `flowerbeds` перед общим `/napravleniya/{slug}`, метод `MainController::flowerbeds` по образцу `directions`, ключ `flowerbeds` в `config/pages.php`, миграция-данные создаёт строку `page_contents`, шаблон на каркасе редизайна (`rd-hero--crumbs`, `rd-text`, `x-elitvid.works`). Текст и фото — через админку.

## Constitution Check

- Маршрут подтверждён в `routes/web.php`, ссылки через `route('flowerbeds')` — PASS.
- Текст не хардкодится: `category_description` из админки — PASS.
- Миграция по спеке (FR-004) — PASS.

## Files

```text
routes/web.php, routes/breadcrumbs.php, config/pages.php
app/Http/Controllers/MainController.php, app/Http/Controllers/SitemapController.php
database/migrations/2026_11_21_120000_add_flowerbeds_page_content.php
resources/views/elitvid/site/flowerbeds.blade.php
resources/views/includes/elitvid/redesign-directions.blade.php, components/elitvid/footer.blade.php
public/elitvid_assets/redesign/redesign.css
tests/Feature/FlowerbedsPageTest.php
```
