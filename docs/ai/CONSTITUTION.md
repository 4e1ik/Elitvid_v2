# Elitvid — карта системы для AI

Компактный контекст текущей системы. Правила нового кода — `.specify/memory/constitution.md`. Эти два файла не склеивать.

## Что это

Публичный сайт изделий из полистоуна (скамейки, кашпо, урны, направления, блог, заявки, корзина) и админка в том же Laravel-приложении. Локально: http://localhost:8080, подъём `make init`, база `elitvid_db`.

## Стек

- PHP 8.5, Laravel 13, Blade; Inertia v2 заявлен в `composer.json`
- Загрузка приложения и middleware — `bootstrap/app.php`
- MariaDB в Docker, с хоста порт 3306, хост внутри сети `mysql`
- Redis, Nginx, очереди Horizon заявлены в `composer.json`

## Роли

В `App\Enums\UserRole`: `admin` (Администратор), `manager` (Менеджер), `viewer` (Обзорный).

В локальной базе на момент описания есть один пользователь с ролью `admin`. Строк `manager` и `viewer` нет. Матрица доступа всё равно задана маршрутами в `routes/web.php`.

## Куда смотреть в коде

| Слой | Путь | Роль |
|---|---|---|
| Публичные и админ-маршруты | `routes/web.php` | единственный набор HTTP-входов сайта |
| Публичные контроллеры | `app/Http/Controllers` | главная, каталог, урны, блог, заявка, корзина |
| Админка | `app/Http/Controllers/Admin` | товары, урны, страницы, письма, заказы, пользователи |
| Сервисы и репозитории | `app/Services`, `app/Repositories` | корзина в сессии, заказы, выборки урн |
| Роли | `app/Enums/UserRole.php`, `app/Http/Middleware/RoleAccessMiddleware.php`, `DenyRolesMiddleware.php` | кто входит и кто может писать |
| Фиксированные страницы | `config/pages.php` | ключи страниц, которые не создаются как запись админки |
| Модели | `app/Models` | товары, скамейки, кашпо, урны, заказы, блог, письма, страницы |

## Документы

| Слой | Путь |
|---|---|
| Эта карта | `docs/ai/CONSTITUTION.md` |
| Точки входа | `docs/ai/SERVICE_MAP.md` |
| Граф | `docs/ai/graphify-out/` |
| Текст для человека | `docs/human/` |

Вход в локальную админку для проверки — `ADMIN_EMAIL` и `ADMIN_PASSWORD` в `.env`. Значения в документы не копировать.
