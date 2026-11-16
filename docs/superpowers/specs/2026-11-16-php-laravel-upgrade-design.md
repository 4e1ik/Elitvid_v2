# PHP 8.5 и Laravel 13

## Цель

Локальный Docker сайта `Elitvid_v2` поднимается на той же младшей ветке PHP, что и прод, и на Laravel 13 с каркасом Laravel 13.

Прод уже на PHP 8.5.12. Образ `php-fpm` в конце работы — `php:8.5-fpm`. Патч официального образа может отличаться от `.12`; совпадает ветка 8.5. `composer.json` требует `"php": "^8.5"` и `"laravel/framework": "^13.0"`. `php artisan --version` показывает Laravel 13.

Поведение сайта остаётся прежним: публичные страницы, корзина, заказ, админка, загрузка картинок через Imagick.

Выкладка на прод в эту работу не входит. Она начинается после зелёного локального прогона.

## Границы

Остаётся как есть:

- MariaDB 10.3. Laravel 13 принимает MariaDB 10.3+.
- Публичные Blade-страницы.
- Inertia останавливается на 2. Версия 1 не ставится на PHP 8.5 и Laravel 13. Версия 2 ставится и на текущий Laravel 10, и на Laravel 13.
- Сериализация сессии остаётся `php`, если скелет Laravel 13 предлагает `json`. Так текущие сессии не сбрасываются.

Ветку `upgrade/php85-laravel13` ведём от текущего состояния `Elitvid_v2`. Каждый шаг — отдельный коммит. Следующий шаг начинается только после пройденных ворот.

## Ворота каждого шага

1. `phpunit` зелёный.
2. В браузере на http://localhost:8080 открываются главная, одна страница каталога, страница корзины и страница входа в админку.

Красные ворота чинятся внутри того же шага. Следующий мажор Laravel на красных воротах не начинается.

Шаг 0 не меняет код. Те же ворота прогоняются на PHP 8.1 и Laravel 10.48.28. Следующий шаг начинается только если они зелёные.

## Порядок

Laravel 10 поддерживает PHP до 8.3 включительно. Laravel 12 — первая ветка, которая принимает PHP 8.5. Поэтому образ переходит на 8.5 после Laravel 12, а не в начале.

1. Убрать `biscolab/laravel-recaptcha`.
2. Поднять Inertia до 2: `inertiajs/inertia-laravel` ^2 и `@inertiajs/react` ^2.
3. Образ `php:8.1-fpm` заменить на `php:8.3-fpm`. В `composer.json` поставить `"php": "^8.3"`.
4. Laravel 10 → 11 по официальному upgrade guide этой версии. `app/Http/Kernel.php` и `app/Console/Kernel.php` остаются.
5. Laravel 11 → 12 по официальному upgrade guide. Ядра остаются.
6. Образ заменить на `php:8.5-fpm`. В `composer.json` поставить `"php": "^8.5"`.
7. Laravel 12 → 13 по официальному upgrade guide. Известные ограничения этой версии: `laravel/tinker` ^3.0, `phpunit/phpunit` ^12.0.
8. Перевести приложение на каркас Laravel 13. К этому моменту сайт уже открывается на Laravel 13.

На шагах 4, 5 и 7 ограничения пакетов берутся из upgrade guide этой версии, затем выполняется `composer update`. Если Composer отказывает пакету, в этом же шаге пакет поднимается до релиза, который принимает целевой Laravel. Исключение — `laravel/breeze`: это генератор скаффолда, приложению для работы он не нужен. Если релиза под целевой Laravel нет, пакет удаляется из `require-dev`. Сгенерированный код аутентификации остаётся.

Перед шагом 7 ещё раз ищется своё определение `array_first` и `array_last`. Сейчас в коде приложения таких функций нет. Полифилл Symfony в Laravel 13 объявляет их глобально на PHP ниже 8.5. На образе 8.5 к моменту шага 7 эти функции уже есть в самом PHP.

## Пакеты, которые не переживают переход

### reCAPTCHA

Заказ уже проверяет токен сам: `PlaceOrderRequest` делает POST на `https://www.google.com/recaptcha/api/siteverify` и читает `config('services.recaptcha.secret_key')`. Скрипты в шаблонах берут `config('services.recaptcha.site_key')`. Классы `Biscolab\` в коде приложения не вызываются. Пакет только подключается автообнаружением и держит `config/recaptcha.php`.

На шаге 1 пакет удаляется, `config/recaptcha.php` удаляется. `config/services.php`, шаблоны и `PlaceOrderRequest` остаются. Регрессия — `tests/Feature/CartOrderTest.php`: он уже подменяет ответ Google.

### Inertia

`inertia-laravel` 0.6 и линейка 1.x не принимают Laravel 13. Линейка 1.x ещё и ограничивает PHP веткой 8.4. Линейка 2 принимает Laravel 10–13 и PHP ^8.1, поэтому её ставят ещё на Laravel 10.

На шаге 2 серверный адаптер и `@inertiajs/react` поднимаются до ^2 по upgrade guide Inertia 2. `HandleInertiaRequests` остаётся в группе `web`. Публичные Blade-страницы не переписываются.

### Образ PHP

В `docker/php/Dockerfile` расширения ставятся так же, как сейчас: gd с freetype, jpeg и webp, pdo_mysql, mbstring, exif, pcntl, bcmath, mysqli, Imagick, Xdebug.

PECL-пакеты фиксируются: `imagick-3.8.1` и `xdebug-3.5.3`. Оба собираются на PHP 8.5. Если на 8.3 или 8.5 сборка с этими пинами падает, пин меняется внутри того же шага, до перехода к следующему мажору.

Node.js 20 в образе остаётся.

## Каркас Laravel 13

Шаг 8 меняет структуру загрузки. Маршруты, middleware и команды к этому моменту уже работают на Laravel 13.

`bootstrap/app.php` переписывается на `Application::configure` со скелета Laravel 13:

- `withRouting` регистрирует `routes/web.php` с middleware `web`, `routes/api.php` с префиксом `api` и middleware `api`, `routes/console.php`. Команда `inspire` в `routes/console.php` остаётся.
- Лимит `api` — 60 запросов в минуту по id пользователя или IP, как сейчас в `RouteServiceProvider`.
- `withMiddleware` переносит глобальный стек, группы `web` и `api` и алиасы из `app/Http/Kernel.php`. В группе `web` остаётся `HandleInertiaRequests`. Алиасы `role.access` и `deny.roles` остаются.
- `withExceptions` подключает стандартную обработку. `app/Exceptions/Handler.php` только задаёт стандартный `$dontFlash` для трёх полей пароля и пустой `reportable`. Класс удаляется: то же исключение полей есть в базовом обработчике.
- Расписание в `app/Console/Kernel.php` пустое, поэтому `withSchedule` не добавляется.

`bootstrap/providers.php` получает текущие провайдеры приложения:

- `AppServiceProvider`
- `AuthServiceProvider`
- `EventServiceProvider`
- `BreadcrumbsServiceProvider`
- `ViewServiceProvider`

`BroadcastServiceProvider` сейчас закомментирован и в список не попадает. `HorizonServiceProvider` в `config/app.php` не записан. Если после шага 8 маршруты Horizon пропадают, провайдер добавляется в `bootstrap/providers.php` в этом же шаге.

`config/app.php` приводится к форме скелета Laravel 13. Сохраняются текущие значения `name`, `env`, `debug`, `url`, `asset_url`, `timezone` (UTC), `locale` (ru), `fallback_locale` (en), `faker_locale`, `key`, `cipher` и `maintenance`. Длинный список каркасных провайдеров из файла уходит: свои провайдеры живут в `bootstrap/providers.php`.

Редирект после входа остаётся `/dashboard`. Сейчас это `RouteServiceProvider::HOME`. После удаления провайдера путь прописывается в четырёх местах: `RedirectIfAuthenticated`, `tests/Feature/Auth/AuthenticationTest.php`, `tests/Feature/Auth/RegistrationTest.php`, `tests/Feature/Auth/EmailVerificationTest.php`.

Классы `app/Http/Kernel.php`, `app/Console/Kernel.php` и `app/Providers/RouteServiceProvider.php` удаляются. Команды в `app/Console/Commands/` Laravel 13 подхватывает сам, включая `ParseStaticImages`.

## Конец работы

Одновременно верно всё:

- в контейнере `php -v` показывает 8.5.x;
- `php artisan --version` показывает Laravel 13;
- `composer.json` требует PHP ^8.5 и `laravel/framework` ^13.0;
- `biscolab/laravel-recaptcha` в зависимостях нет;
- стоят `inertiajs/inertia-laravel` ^2 и `@inertiajs/react` ^2;
- файлов `app/Http/Kernel.php` и `app/Console/Kernel.php` нет;
- `bootstrap/app.php` собран через `Application::configure`;
- ворота шага зелёные.
