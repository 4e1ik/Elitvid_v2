# Implementation Plan: Скамьи в новом виде

**Branch**: `006-benches-redesign` | **Spec**: [spec.md](spec.md)

## Summary

Тот же каркас, что в 005: `rd-hero--crumbs`, `x-elitvid.breadcrumbs`, `x-elitvid.download-catalog`, `x-elitvid.form-row` (новый вариант «текст и кнопка справа»), общий шаблон страницы коллекции `x-elitvid.collection-page` (им же пересобираются «Круглые кашпо»). Карточка скамейки получает правки карточки кашпо. Street furniture: маршрут списка — 301 на «Скамьи из камня», маршрут товара — 301 по правилу US2 сц. 5, запись в sitemap убирается. Состав — через админку.

## Constitution Check

- Маршруты: `street_furniture_benches` остаётся именем (на него ссылается админка через helper), отвечает 301 — PASS.
- `inCart` с бэкенда (`CartService::has`) — PASS.
- Админка не меняется — PASS.

## Files

```text
routes/web.php, routes/breadcrumbs.php
app/Http/Controllers/BenchController.php, app/Http/Controllers/SitemapController.php
resources/views/components/elitvid/collection-page.blade.php (новый), form-row.blade.php
resources/views/elitvid/site/benches.blade.php, benches/{verona,stones,lines,solo}_benches.blade.php, benches/bench_product_page.blade.php
resources/views/elitvid/site/pots/round_pots.blade.php
resources/views/elitvid/site/benches/street_furniture_benches.blade.php (удаляется)
public/elitvid_assets/redesign/redesign.css, images/*-hero.webp
tests/Feature/BenchRedirectTest.php (новый)
```
