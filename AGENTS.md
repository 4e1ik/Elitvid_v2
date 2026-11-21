# AGENTS.md

## Назначение

Elitvid v2 — публичный сайт изделий из полистоуна (скамейки, кашпо, направления, блог, заявки, корзина) и админка. Один репозиторий: Laravel 13, PHP 8.5, Blade. Сайт — http://localhost:8080, подъём `make init` (см. `README.md`).

## Карта

- `app/` — код бэкенда: контроллеры (`Http/Controllers`, админка в `Http/Controllers/Admin`), Form Request, DTO, сервисы (`Services`, `Services/Admin`), репозитории (`Repositories`, `Repositories/Admin`), модели, enum, middleware, helpers.
- `routes/web.php` — все HTTP-входы сайта и админки.
- `database/` — миграции. `config/pages.php` — ключи фиксированных страниц. `tests/` — PHPUnit.
- `resources/views/` — Blade-шаблоны, публичные и админские. Свои правила — в `resources/views/AGENTS.md`.
- `specs/<NNN-фича>/` — спеки (spec, plan, tasks). `.specify/` — spec-kit. Ветка и папка спеки называются одинаково: `NNN-имя`, например `002-user-cart`.
- `docs/ai/` — карта системы для AI, `docs/human/` — для человека. Пишет `/elitvid-docs` из окна родительской папки, не сюда вручную. Исключение — граф `docs/ai/graphify-out/`: его пересобирает любая задача по правилу «Граф и MCP» в `../AGENTS.md`.
- `docs/superpowers/` — черновики обсуждений. В `specs/` их не переносить.
- Скрипты spec-kit из родительского окна должны задавать `SPECIFY_INIT_DIR` на этот репозиторий. Без этой переменной запускайте их изнутри `Elitvid_v2`.

## Архитектура

- Новый серверный код фичи: Controller → Request → DTO → Service → Repository, в этом порядке.
- Controller принимает запрос и вызывает сервис с DTO. Данные собирает Form Request через `toData()`. Образец — `app/Http/Controllers/CartController.php`.
- Валидация — в Form Request (`app/Http/Requests`). Контроллер её не пишет.
- DTO несёт данные и не содержит логики. Образец — `app/DTO/PlaceOrderData.php`.
- Service принимает DTO и выполняет сценарий. К базе и моделям напрямую не обращается. Образец — `app/Services/Admin/OrderService.php`.
- Repository — единственный слой запросов. Образец — `app/Repositories/OrderRepository.php`.
- Существующий код, который обходит слои (например, `CartService::lines()` читает `Product` напрямую, `app/Helpers`), в новый код как образец не копировать.
- Публичный сайт и админка отдают Blade. JSON — только там, где экран его уже ждёт (как `cart.add` при `expectsJson()`).
- Правило предметной области живёт на бэкенде. Вьюха его вторым источником истины не заводит.
- Принципы нового кода — `.specify/memory/constitution.md`. Сейчас это пустой шаблон без принципов, поэтому действуют правила этого файла. Workflow spec-kit сюда не копировать.

## Жёсткие инварианты

- Маршрут, имя маршрута и payload подтверждать в `routes/web.php`, контроллере и Blade. Не выдумывать.
- Версии PHP 8.5, Laravel 13 и уже стоящих библиотек не менять. `composer update` не запускать: `composer.lock` зафиксирован под PHP 8.5 (образ `docker/php/Dockerfile`). Новую библиотеку ставить только если без неё задачу не сделать, и в версии, которая стыкуется с PHP 8.5.
- В Service и Repository не заводить внутренний метод с одним вызывающим. Такой шаг остаётся в методе, который его использует.
- Роли — `App\Enums\UserRole`: `admin`, `manager`, `viewer`. Доступ задаётся в `routes/web.php`: `role.access:<роли>` (разрешить) и `deny.roles:<роли>` (запретить). Пишущие маршруты закрыты для `viewer` через `deny.roles:viewer`, удаление — `role.access:admin`. Меню админки по роли — `resources/views/layouts/elitvid/admin/admin.blade.php`; скрытая кнопка не заменяет middleware.
- Код, миграции и конфиги менять по активной спеке в `specs/`. Миграции и базу — только по спеке.
- Пока идёт `/elitvid-docs`: код приложения, миграции и базу не менять. Базу `elitvid_db` только читать (`SELECT`).
- Дампы `cr48940_elitvid*.sql` не править. `make init` и `make db-import` перезаливают `elitvid_db`: без прямой просьбы не запускать.
- `.env` и секреты не коммитить и в чат не копировать. `ADMIN_EMAIL` и `ADMIN_PASSWORD` из `.env` — только для входа на http://localhost:8080/login, чтобы описать админку и проверить сделанное.
- `.cursor/skills/speckit-*` и `.specify/` обновляет spec-kit. Навыки и правила kit документации в этот репозиторий не копировать.
- Фронт (Blade, CSS, JS) — отдельный `resources/views/AGENTS.md`. Этот файл бэкенда.

## Проверка перед «готово»

- Бэкенд: из контейнера PHP (`make app`) запустить `./vendor/bin/phpunit` (весь набор или `--filter <имя>`). Тесты: `tests/Feature/CartOrderTest.php` (корзина и заказы), `tests/Feature/Auth/AuthenticationTest.php` (вход и выход). `phpunit.xml` принудительно направляет тесты в отдельную базу `elitvid_testing`, `elitvid_db` они не трогают. Базу создаёт `make test-db` (и `make init`). Запускать только с разрешения пользователя.
- Сайт: если у спеки есть `quickstart.md`, пройти его сценарий на http://localhost:8080.
- В `package.json` есть только `dev` и `build`. Отдельной команды фронтовых тестов нет.
