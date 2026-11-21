# PHP 8.5 and Laravel 13 Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Run Elitvid_v2 on PHP 8.5 and Laravel 13 with the Laravel 13 application skeleton, without changing site behavior.

**Architecture:** One branch, one major per commit. PHP moves 8.1 → 8.3 while Laravel is still 10, then Laravel 10 → 11 → 12, then PHP 8.5, then Laravel 12 → 13, and only then the skeleton. `Http/Kernel` and `Console/Kernel` stay in place until the last task. reCAPTCHA stays on the existing Google `siteverify` calls. Inertia stops at v2.

**Tech Stack:** PHP 8.5, Laravel 13, Docker `php-fpm`, MariaDB 10.3, Inertia React 2, PHPUnit, nginx on http://localhost:8080.

## Global Constraints

- Finish on image `php:8.5-fpm`. The production patch is 8.5.12; the image patch may differ. The 8.5 line is the match that matters.
- `composer.json` ends with `"php": "^8.5"` and `"laravel/framework": "^13.0"`.
- MariaDB stays 10.3.
- Public Blade pages stay Blade.
- Inertia stops at 2: `inertiajs/inertia-laravel` ^2 and `@inertiajs/react` ^2.
- Session serialization stays `php`.
- reCAPTCHA keys stay `RECAPTCHA_SITE_KEY` and `RECAPTCHA_SECRET_KEY`. `PlaceOrderRequest` and `MailRequest` keep their own POST to `https://www.google.com/recaptcha/api/siteverify`.
- Redirect after login stays `/dashboard`.
- Each task is one commit on `upgrade/php85-laravel13`. The next task starts only after the gate below is green.
- Do not deploy to production in this plan.
- All commands run from `/Users/user/projects/Elitvid/Elitvid_v2`. Git commands use that directory: it is the git root.

**Gate, repeated in every task after the first:**

```bash
docker exec php_elitvid php artisan test
```

Expected: PHPUnit ends with `OK`, exit code 0.

```bash
for path in / /napravleniya/skami /cart /login; do
  code=$(curl -s -o /dev/null -w "%{http_code}" "http://localhost:8080${path}")
  echo "$code $path"
  test "$code" = "200"
done
```

Expected: four lines, each starting with `200`.

---

### Task 1: Baseline on PHP 8.1 and Laravel 10

**Files:**
- Create: none
- Modify: none
- Test: existing `tests/Feature` and `tests/Unit`

**Interfaces:**
- Consumes: the current tree, image `php:8.1-fpm`, Laravel 10.48.28
- Produces: branch `upgrade/php85-laravel13` with a green gate. Later tasks commit only on this branch.

- [ ] **Step 1: Create the branch**

```bash
git checkout -b upgrade/php85-laravel13
git status -sb
```

Expected: `## upgrade/php85-laravel13`.

- [ ] **Step 2: Confirm the container is the current stack**

```bash
docker exec php_elitvid php -v
docker exec php_elitvid php artisan --version
```

Expected: PHP 8.1.x and `Laravel Framework 10.48.28`.

- [ ] **Step 3: Run the gate**

```bash
docker exec php_elitvid php artisan test
for path in / /napravleniya/skami /cart /login; do
  code=$(curl -s -o /dev/null -w "%{http_code}" "http://localhost:8080${path}")
  echo "$code $path"
  test "$code" = "200"
done
```

Expected: PHPUnit `OK` and four `200` lines.

If either command fails, stop. Do not start Task 2. The failure is pre-existing and has to be fixed before this upgrade.

- [ ] **Step 4: Do not commit**

This task does not change files.

---

### Task 2: Remove the unused reCAPTCHA package

**Files:**
- Modify: `composer.json`, `composer.lock`
- Delete: `config/recaptcha.php`
- Test: `tests/Feature/CartOrderTest.php`

**Interfaces:**
- Consumes: `config('services.recaptcha.site_key')` and `config('services.recaptcha.secret_key')` from `config/services.php`
- Produces: no `biscolab/laravel-recaptcha` dependency. Order and mail forms still verify tokens with `Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', ...)`.

- [ ] **Step 1: Confirm application code does not call the package**

```bash
rg -n "Biscolab\\\\|ReCaptcha::|config\\('recaptcha" app resources routes tests
```

Expected: no matches. `config/recaptcha.php` and `vendor/` are outside this search on purpose.

- [ ] **Step 2: Remove the package**

```bash
docker exec php_elitvid composer remove biscolab/laravel-recaptcha
```

Expected: `composer.json` and `composer.lock` no longer contain `biscolab/laravel-recaptcha`. Exit code 0.

- [ ] **Step 3: Delete the package config**

Delete the file `config/recaptcha.php`.

Leave `config/services.php` as it is:

```php
    'recaptcha' => [
        'site_key' => env('RECAPTCHA_SITE_KEY'),
        'secret_key' => env('RECAPTCHA_SECRET_KEY'),
    ],
```

Leave `app/Http/Requests/PlaceOrderRequest.php` and `app/Http/Requests/MailRequest.php` unchanged. Their `g-recaptcha-response` closures stay.

- [ ] **Step 4: Run the order regression, then the gate**

```bash
docker exec php_elitvid php artisan test --filter=CartOrderTest
docker exec php_elitvid php artisan test
for path in / /napravleniya/skami /cart /login; do
  code=$(curl -s -o /dev/null -w "%{http_code}" "http://localhost:8080${path}")
  echo "$code $path"
  test "$code" = "200"
done
```

Expected: `CartOrderTest` passes, then the full gate is green.

- [ ] **Step 5: Commit**

```bash
git add composer.json composer.lock config/recaptcha.php
git commit -m "$(cat <<'EOF'
chore: drop the unused recaptcha package

Order and mail forms already verify tokens against Google siteverify.
EOF
)"
```

---

### Task 3: Upgrade Inertia from 1 to 2

**Files:**
- Modify: `composer.json`, `composer.lock`, `package.json`, `package-lock.json`
- Test: `tests/Feature/Auth/AuthenticationTest.php` (Inertia login screen) and `npm run build`

**Interfaces:**
- Consumes: `resources/js/app.jsx` calling `createInertiaApp` from `@inertiajs/react`, and page components importing `Head`, `Link`, `useForm`, `usePage` from `@inertiajs/react`
- Produces: `inertiajs/inertia-laravel` ^2 and `@inertiajs/react` ^2. `resources/js/app.jsx` stays on the same `createInertiaApp` call. `HandleInertiaRequests` stays in the `web` group.

- [ ] **Step 1: Set the constraints**

In `composer.json` `require`, replace:

```json
"inertiajs/inertia-laravel": "^0.6.3",
```

with:

```json
"inertiajs/inertia-laravel": "^2.0",
```

In `package.json` `devDependencies`, replace:

```json
"@inertiajs/react": "^1.0.0",
```

with:

```json
"@inertiajs/react": "^2.0.0",
```

Do not change `resources/js/app.jsx`. It already uses the v1 adapter entry that v2 keeps:

```jsx
import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.jsx`, import.meta.glob('./Pages/**/*.jsx')),
    setup({ el, App, props }) {
        const root = createRoot(el);
        root.render(<App {...props} />);
    },
    progress: {
        color: '#4B5563',
    },
});
```

- [ ] **Step 2: Install**

```bash
docker exec php_elitvid composer update inertiajs/inertia-laravel --with-all-dependencies
docker exec php_elitvid npm install
docker exec php_elitvid npm run build
```

Expected: Composer installs `inertia-laravel` 2.x. `npm run build` exits 0.

- [ ] **Step 3: Run the gate**

```bash
docker exec php_elitvid php artisan test
for path in / /napravleniya/skami /cart /login; do
  code=$(curl -s -o /dev/null -w "%{http_code}" "http://localhost:8080${path}")
  echo "$code $path"
  test "$code" = "200"
done
```

Expected: green gate. `/login` is the admin Blade screen. The Inertia login covered by `AuthenticationTest` is exercised inside `php artisan test`.

- [ ] **Step 4: Commit**

```bash
git add composer.json composer.lock package.json package-lock.json
git commit -m "$(cat <<'EOF'
chore: upgrade Inertia to v2

v1 cannot be installed on PHP 8.5 or Laravel 13.
EOF
)"
```

---

### Task 4: Move the image to PHP 8.3

**Files:**
- Modify: `docker/php/Dockerfile`, `composer.json`, `composer.lock`
- Test: gate, plus `php -v` inside `php_elitvid`

**Interfaces:**
- Consumes: Laravel 10, which accepts PHP 8.3
- Produces: image `php:8.3-fpm`, `"php": "^8.3"`, Imagick 3.8.1, Xdebug 3.5.3. Laravel stays on 10.x.

- [ ] **Step 1: See which packages refuse PHP 8.3**

```bash
docker exec php_elitvid composer prohibits php 8.3
```

Expected: no package lines. If a package is listed, raise that package to a release that allows PHP 8.3 before rebuilding, then run the same command again until it prints no blocking packages.

- [ ] **Step 2: Pin PHP 8.3 and the PECL extensions**

Replace the first line of `docker/php/Dockerfile`:

```dockerfile
FROM php:8.3-fpm
```

Replace the Imagick install:

```dockerfile
 && pecl install imagick-3.8.1 \
```

Replace the Xdebug install:

```dockerfile
RUN pecl install xdebug-3.5.3 \
    && docker-php-ext-enable xdebug
```

In `composer.json` `require`, replace:

```json
"php": "^8.1",
```

with:

```json
"php": "^8.3",
```

- [ ] **Step 3: Rebuild and refresh the lock**

```bash
docker compose build php-fpm
docker compose up -d php-fpm
docker exec php_elitvid php -v
docker exec php_elitvid composer update --with-all-dependencies
docker exec php_elitvid php artisan --version
```

Expected: PHP 8.3.x, Composer exits 0, `Laravel Framework 10.` is still the version line.

- [ ] **Step 4: Run the gate**

```bash
docker exec php_elitvid php artisan test
for path in / /napravleniya/skami /cart /login; do
  code=$(curl -s -o /dev/null -w "%{http_code}" "http://localhost:8080${path}")
  echo "$code $path"
  test "$code" = "200"
done
```

Expected: green gate.

- [ ] **Step 5: Commit**

```bash
git add docker/php/Dockerfile composer.json composer.lock
git commit -m "$(cat <<'EOF'
chore: run the app on PHP 8.3

Laravel 10 accepts 8.3, and 8.5 is not available until Laravel 12.
EOF
)"
```

---

### Task 5: Upgrade Laravel 10 to 11

**Files:**
- Modify: `composer.json`, `composer.lock`, `config/sanctum.php`
- Create: `database/migrations/2019_12_14_000001_create_personal_access_tokens_table.php` when `vendor:publish` writes that Sanctum file
- Test: gate
- Do not modify: `app/Http/Kernel.php`, `app/Console/Kernel.php`, `bootstrap/app.php`, `public/index.php`, `artisan`, the four existing `->change()` migrations

**Interfaces:**
- Consumes: PHP 8.3, Inertia 2, Sanctum 3 config keys `verify_csrf_token` and `encrypt_cookies`
- Produces: `laravel/framework` ^11.0, `laravel/sanctum` ^4.0, `nunomaduro/collision` ^8.1. Kernels still boot the app. Sanctum middleware keys become `authenticate_session`, `encrypt_cookies`, `validate_csrf_token` and still point at this app's cookie and CSRF middleware.

- [ ] **Step 1: Set the constraints from the Laravel 11 upgrade guide**

In `composer.json` `require`:

```json
"laravel/framework": "^11.0",
"laravel/sanctum": "^4.0",
"laravel/breeze": "^2.0",
```

Leave `"inertiajs/inertia-laravel": "^2.0"`. The Laravel 11 guide mentions `^1.0`; that pin is older than Task 3 and must not be applied.

In `composer.json` `require-dev`:

```json
"nunomaduro/collision": "^8.1",
```

Leave `phpunit/phpunit` at `^10.1` for this task. Leave `laravel/horizon` at `^5.24`: Horizon 5.51 already accepts Laravel 11 through 13, and `^5.24` allows that release.

- [ ] **Step 2: Update Composer**

```bash
docker exec php_elitvid composer update --with-all-dependencies
```

Expected: exit 0, `php artisan --version` prints `Laravel Framework 11.`.

If Composer refuses `laravel/breeze`, run:

```bash
docker exec php_elitvid composer remove --dev laravel/breeze
```

The generated auth code stays. Then rerun the update.

If Composer refuses another package, run:

```bash
docker exec php_elitvid composer prohibits laravel/framework 11.0
```

Raise only the named package to a release that accepts Laravel 11, then rerun `composer update --with-all-dependencies`. Do not start Task 6 until this command exits 0.

- [ ] **Step 3: Publish Sanctum migrations without recreating an existing table**

```bash
docker exec elitvid_db mysql -uroot -proot -N -e "SHOW TABLES LIKE 'personal_access_tokens'" elitvid_db
docker exec php_elitvid php artisan vendor:publish --tag=sanctum-migrations --no-interaction
docker exec php_elitvid php artisan migrate --pretend
```

If `SHOW TABLES` printed `personal_access_tokens` and `migrate --pretend` lists a new `create_personal_access_tokens_table` migration, do not run `migrate`. Record that filename as already applied:

```bash
file=$(basename database/migrations/*personal_access_tokens*.php .php)
docker exec elitvid_db mysql -uroot -proot elitvid_db -e "INSERT INTO migrations (migration, batch) SELECT '${file}', COALESCE(MAX(batch), 1) FROM migrations;"
```

If the table name was not printed, run:

```bash
docker exec php_elitvid php artisan migrate --force
```

- [ ] **Step 4: Point Sanctum at the same middleware classes**

Replace the `middleware` array in `config/sanctum.php` with:

```php
    'middleware' => [
        'authenticate_session' => \Laravel\Sanctum\Http\Middleware\AuthenticateSession::class,
        'encrypt_cookies' => \App\Http\Middleware\EncryptCookies::class,
        'validate_csrf_token' => \App\Http\Middleware\VerifyCsrfToken::class,
    ],
```

- [ ] **Step 5: Confirm the column-change migrations stay untouched**

These files already ran. Laravel 11 drops unstated column modifiers on a fresh `->change()`, and this upgrade does not rewrite history:

- `database/migrations/2026_01_16_100005_update_galleries_table_for_polymorphic_relation.php`
- `database/migrations/2026_01_24_170000_add_unique_index_to_galleries_type.php`
- `database/migrations/2024_11_23_094422_change_material_size_weight_price_columnns_in_pot_products_table.php`
- `database/migrations/2024_11_23_094429_change_material_size_weight_price_columnns_in_bench_products_table.php`

```bash
git diff --name-only -- database/migrations
```

Expected: empty, or only the newly published Sanctum migration.

- [ ] **Step 6: Run the gate**

```bash
docker exec php_elitvid php artisan --version
docker exec php_elitvid php artisan test
for path in / /napravleniya/skami /cart /login; do
  code=$(curl -s -o /dev/null -w "%{http_code}" "http://localhost:8080${path}")
  echo "$code $path"
  test "$code" = "200"
done
```

Expected: Laravel 11 and a green gate. `app/Http/Kernel.php` still exists.

- [ ] **Step 7: Commit**

```bash
git add composer.json composer.lock config/sanctum.php database/migrations
git commit -m "$(cat <<'EOF'
chore: upgrade Laravel to 11

Keep the HTTP and console kernels until the app is on Laravel 13.
EOF
)"
```

---

### Task 6: Upgrade Laravel 11 to 12

**Files:**
- Modify: `composer.json`, `composer.lock`
- Test: gate
- Do not modify: kernels, `bootstrap/app.php`, `public/index.php`, `artisan`, `config/filesystems.php`

**Interfaces:**
- Consumes: Laravel 11 on PHP 8.3
- Produces: `laravel/framework` ^12.0 and `phpunit/phpunit` ^11.0. The `local` disk root stays `storage_path('app')`.

- [ ] **Step 1: Confirm the low-impact Laravel 12 changes do not touch this code**

```bash
rg -n "HasUuids|HasVersion7Uuids|mergeIfMissing\\(|Schema::getTables\\(|Schema::getTableListing\\(" app
```

Expected: no matches.

`config/filesystems.php` already sets the local disk root:

```php
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],
```

Leave that array as it is. Laravel 12's new default root is `storage/app/private` only when the disk is missing.

- [ ] **Step 2: Set the constraints from the Laravel 12 upgrade guide**

```json
"laravel/framework": "^12.0",
```

in `require`, and in `require-dev`:

```json
"phpunit/phpunit": "^11.0",
```

- [ ] **Step 3: Update Composer**

```bash
docker exec php_elitvid composer prohibits laravel/framework 12.0
docker exec php_elitvid composer update --with-all-dependencies
docker exec php_elitvid php artisan --version
```

Expected: the prohibits command prints no blocking packages after any raises you make from its output, the update exits 0, and the version line is `Laravel Framework 12.`.

If `laravel/breeze` is the blocker, remove it with `composer remove --dev laravel/breeze` and update again.

- [ ] **Step 4: Run the gate**

```bash
docker exec php_elitvid php artisan test
for path in / /napravleniya/skami /cart /login; do
  code=$(curl -s -o /dev/null -w "%{http_code}" "http://localhost:8080${path}")
  echo "$code $path"
  test "$code" = "200"
done
```

Expected: green gate.

- [ ] **Step 5: Commit**

```bash
git add composer.json composer.lock
git commit -m "$(cat <<'EOF'
chore: upgrade Laravel to 12

PHP 8.5 becomes installable on the next task.
EOF
)"
```

---

### Task 7: Move the image to PHP 8.5

**Files:**
- Modify: `docker/php/Dockerfile`, `composer.json`, `composer.lock`
- Test: gate, plus `php -v`

**Interfaces:**
- Consumes: Laravel 12, which accepts PHP 8.5
- Produces: image `php:8.5-fpm` and `"php": "^8.5"`. Imagick stays `imagick-3.8.1`. Xdebug stays `xdebug-3.5.3`.

- [ ] **Step 1: See which packages refuse PHP 8.5**

```bash
docker exec php_elitvid composer prohibits php 8.5
```

Expected: no package lines. Raise any listed package to a release that allows PHP 8.5, then run the command again.

- [ ] **Step 2: Switch the image and the platform constraint**

In `docker/php/Dockerfile`:

```dockerfile
FROM php:8.5-fpm
```

Leave these lines as Task 4 wrote them:

```dockerfile
 && pecl install imagick-3.8.1 \
```

```dockerfile
RUN pecl install xdebug-3.5.3 \
    && docker-php-ext-enable xdebug
```

In `composer.json`:

```json
"php": "^8.5",
```

- [ ] **Step 3: Rebuild**

```bash
docker compose build php-fpm
docker compose up -d php-fpm
docker exec php_elitvid php -v
docker exec php_elitvid php -m
docker exec php_elitvid composer update --with-all-dependencies
docker exec php_elitvid php artisan --version
```

Expected: PHP 8.5.x, module list contains `gd`, `imagick`, `pdo_mysql`, `mysqli`, `mbstring`, `exif`, `bcmath`, and `xdebug`. Artisan still prints `Laravel Framework 12.`.

- [ ] **Step 4: Run the gate**

```bash
docker exec php_elitvid php artisan test
for path in / /napravleniya/skami /cart /login; do
  code=$(curl -s -o /dev/null -w "%{http_code}" "http://localhost:8080${path}")
  echo "$code $path"
  test "$code" = "200"
done
```

Expected: green gate.

- [ ] **Step 5: Commit**

```bash
git add docker/php/Dockerfile composer.json composer.lock
git commit -m "$(cat <<'EOF'
chore: run the app on PHP 8.5

Match the production 8.5 line before the Laravel 13 hop.
EOF
)"
```

---

### Task 8: Upgrade Laravel 12 to 13

**Files:**
- Modify: `composer.json`, `composer.lock`, `config/session.php`, `app/Http/Middleware/VerifyCsrfToken.php`
- Test: gate
- Do not modify: `bootstrap/app.php`, kernels, `public/index.php`, `artisan`

**Interfaces:**
- Consumes: PHP 8.5, Laravel 12, `VerifyCsrfToken` extending `Illuminate\Foundation\Http\Middleware\VerifyCsrfToken`
- Produces: `laravel/framework` ^13.0, `laravel/tinker` ^3.0, `phpunit/phpunit` ^12.0. Session config contains `'serialization' => 'php'`. The app CSRF middleware extends `PreventRequestForgery`.

- [ ] **Step 1: Search for global helpers that collide with PHP 8.5**

```bash
rg -n "function array_first|function array_last" --glob '*.php' app bootstrap routes
```

Expected: no matches. PHP 8.5 already provides these functions, so no application change follows from an empty result.

- [ ] **Step 2: Set the constraints from the Laravel 13 upgrade guide**

```json
"laravel/framework": "^13.0",
"laravel/tinker": "^3.0",
```

in `require`, and in `require-dev`:

```json
"phpunit/phpunit": "^12.0",
```

Do not add `laravel/boost`. It is not installed, and this upgrade does not introduce it.

- [ ] **Step 3: Update Composer**

```bash
docker exec php_elitvid composer prohibits laravel/framework 13.0
docker exec php_elitvid composer update --with-all-dependencies
docker exec php_elitvid php artisan --version
```

Expected: no remaining blockers, exit 0, `Laravel Framework 13.`.

If `tightenco/ziggy` is listed, set it to `"tightenco/ziggy": "^2.0"` and update again. Ziggy 2 accepts Laravel 13.

If `laravel/breeze` is listed, `composer remove --dev laravel/breeze` and update again.

- [ ] **Step 4: Keep session serialization on php**

At the end of `config/session.php`, immediately above the closing `];`, add:

```php
    'serialization' => 'php',
```

The Laravel 13 skeleton default is `json`. `json` would drop existing sessions. This application keeps `php`.

- [ ] **Step 5: Point the CSRF middleware at the Laravel 13 class**

Replace the contents of `app/Http/Middleware/VerifyCsrfToken.php` with:

```php
<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestForgery as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
}
```

`VerifyCsrfToken` remains the class name the HTTP kernel and Sanctum config already reference. The parent class is the Laravel 13 name. `PreventRequestForgery` also checks `Sec-Fetch-Site`.

- [ ] **Step 6: Run the gate**

```bash
docker exec php_elitvid php artisan test
for path in / /napravleniya/skami /cart /login; do
  code=$(curl -s -o /dev/null -w "%{http_code}" "http://localhost:8080${path}")
  echo "$code $path"
  test "$code" = "200"
done
```

Expected: green gate. A POST from the cart page still has to include the CSRF token, which the existing forms already send.

- [ ] **Step 7: Commit**

```bash
git add composer.json composer.lock config/session.php app/Http/Middleware/VerifyCsrfToken.php
git commit -m "$(cat <<'EOF'
chore: upgrade Laravel to 13

Keep php session serialization so existing sessions stay valid.
EOF
)"
```

---

### Task 9: Adopt the Laravel 13 skeleton

**Files:**
- Modify: `bootstrap/app.php`, `public/index.php`, `artisan`, `config/app.php`, `routes/web.php` (comment only), `app/Http/Middleware/RedirectIfAuthenticated.php`, `tests/Feature/Auth/AuthenticationTest.php`, `tests/Feature/Auth/RegistrationTest.php`, `tests/Feature/Auth/EmailVerificationTest.php`
- Create: `bootstrap/providers.php`
- Delete: `app/Http/Kernel.php`, `app/Console/Kernel.php`, `app/Providers/RouteServiceProvider.php`, `app/Exceptions/Handler.php`
- Test: gate, Horizon route list, `php artisan list`

**Interfaces:**
- Consumes: a booting Laravel 13 app with the old kernels, `RouteServiceProvider::HOME` equal to `/dashboard`, middleware aliases `role.access` and `deny.roles`, `HandleInertiaRequests` on the `web` group, API limiter of 60 requests per minute
- Produces: `Application::configure` in `bootstrap/app.php`. No `App\Http\Kernel`, no `App\Console\Kernel`, no `App\Providers\RouteServiceProvider`. Login redirects still go to `/dashboard`.

- [ ] **Step 1: Record whether Horizon routes exist before the move**

```bash
docker exec php_elitvid php artisan route:list --path=horizon --columns=method,uri
```

Save the output. Task step 7 compares against it.

- [ ] **Step 2: Replace bootstrap/app.php**

Write `bootstrap/app.php`:

```php
<?php

use App\Http\Middleware\DenyRolesMiddleware;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\PreventRequestsDuringMaintenance;
use App\Http\Middleware\RoleAccessMiddleware;
use App\Http\Middleware\TrimStrings;
use App\Http\Middleware\TrustProxies;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            RateLimiter::for('api', function (Request $request) {
                return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
            });
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->use([
            TrustProxies::class,
            HandleCors::class,
            PreventRequestsDuringMaintenance::class,
            \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
            TrimStrings::class,
            \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        ]);

        $middleware->group('web', [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);

        $middleware->group('api', [
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        $middleware->alias([
            'auth' => \App\Http\Middleware\Authenticate::class,
            'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
            'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
            'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
            'can' => \Illuminate\Auth\Middleware\Authorize::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
            'precognitive' => \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,
            'signed' => \App\Http\Middleware\ValidateSignature::class,
            'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
            'role.access' => RoleAccessMiddleware::class,
            'deny.roles' => DenyRolesMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
```

`routes/console.php` still defines the `inspire` command. Classes in `app/Console/Commands/` are loaded by Laravel 13 without `App\Console\Kernel`. The old `schedule()` method was empty, so there is no `withSchedule` call.

- [ ] **Step 3: Register application providers**

Create `bootstrap/providers.php`:

```php
<?php

use App\Providers\AppServiceProvider;
use App\Providers\AuthServiceProvider;
use App\Providers\BreadcrumbsServiceProvider;
use App\Providers\EventServiceProvider;
use App\Providers\ViewServiceProvider;

return [
    AppServiceProvider::class,
    AuthServiceProvider::class,
    EventServiceProvider::class,
    BreadcrumbsServiceProvider::class,
    ViewServiceProvider::class,
];
```

`BroadcastServiceProvider` stays unregistered. It is commented out in the old provider list. `HorizonServiceProvider` is not in that list either; step 7 adds it only if Horizon routes disappear.

- [ ] **Step 4: Replace the front controller and Artisan entry**

Write `public/index.php`:

```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../vendor/autoload.php';

/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
```

Write `artisan`:

```php
#!/usr/bin/env php
<?php

use Illuminate\Foundation\Application;
use Symfony\Component\Console\Input\ArgvInput;

define('LARAVEL_START', microtime(true));

require __DIR__.'/vendor/autoload.php';

/** @var Application $app */
$app = require_once __DIR__.'/bootstrap/app.php';

$status = $app->handleCommand(new ArgvInput);

exit($status);
```

Keep the executable bit on `artisan`:

```bash
chmod +x artisan
```

- [ ] **Step 5: Slim config/app.php and keep this app's values**

Replace `config/app.php` with:

```php
<?php

return [

    'name' => env('APP_NAME', 'Laravel'),

    'env' => env('APP_ENV', 'production'),

    'debug' => (bool) env('APP_DEBUG', false),

    'url' => env('APP_URL', 'http://localhost'),

    'asset_url' => env('ASSET_URL'),

    'timezone' => 'UTC',

    'locale' => 'ru',

    'fallback_locale' => 'en',

    'faker_locale' => 'en_US',

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(
            explode(',', (string) env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    'maintenance' => [
        'driver' => 'file',
    ],

];
```

`locale` stays the literal `ru`. `maintenance.driver` stays `file`. Application providers now live in `bootstrap/providers.php`.

- [ ] **Step 6: Keep the /dashboard redirect without RouteServiceProvider**

In `app/Http/Middleware/RedirectIfAuthenticated.php`, delete the import of `App\Providers\RouteServiceProvider` and replace the redirect line with:

```php
                return redirect('/dashboard');
```

In `tests/Feature/Auth/AuthenticationTest.php` and `tests/Feature/Auth/RegistrationTest.php`, delete the `RouteServiceProvider` import and replace:

```php
        $response->assertRedirect(RouteServiceProvider::HOME);
```

with:

```php
        $response->assertRedirect('/dashboard');
```

In `tests/Feature/Auth/EmailVerificationTest.php`, delete the `RouteServiceProvider` import and replace:

```php
        $response->assertRedirect(RouteServiceProvider::HOME.'?verified=1');
```

with:

```php
        $response->assertRedirect('/dashboard?verified=1');
```

In `routes/web.php`, replace the comment that says routes are loaded by `RouteServiceProvider` with:

```php
| Here is where you can register web routes for your application. These
| routes are loaded by bootstrap/app.php with the "web" middleware group.
```

- [ ] **Step 7: Delete the old kernel classes and boot**

```bash
rm app/Http/Kernel.php app/Console/Kernel.php app/Providers/RouteServiceProvider.php app/Exceptions/Handler.php
docker exec php_elitvid php artisan --version
docker exec php_elitvid php artisan list --raw | rg "^(parse:static-images|inspire|images:convert-to-webp|products:backfill-slugs|site:analyze-performance|migrate:old-products-data) "
docker exec php_elitvid php artisan route:list --path=horizon --columns=method,uri
```

`app/Exceptions/Handler.php` only repeated the framework `$dontFlash` list for `current_password`, `password`, and `password_confirmation`. The base handler still excludes those fields.

Expected: `Laravel Framework 13.`. `php artisan list` prints all six lines: `parse:static-images`, `inspire`, `images:convert-to-webp`, `products:backfill-slugs`, `site:analyze-performance`, and `migrate:old-products-data`.

Compare the Horizon route list with step 1. If step 1 printed Horizon URIs and this command prints none, add this line to the array in `bootstrap/providers.php` and run `php artisan route:list --path=horizon` again:

```php
use App\Providers\HorizonServiceProvider;
```

```php
    HorizonServiceProvider::class,
```

Expected after that: the same Horizon URIs as step 1.

- [ ] **Step 8: Run the gate**

```bash
docker exec php_elitvid php -v
docker exec php_elitvid php artisan --version
test ! -f app/Http/Kernel.php
test ! -f app/Console/Kernel.php
test ! -f config/recaptcha.php
if rg -q "biscolab/laravel-recaptcha" composer.json; then
  echo "biscolab/laravel-recaptcha is still required"
  exit 1
fi
rg -n '"php": "\^8\.5"' composer.json
rg -n '"laravel/framework": "\^13\.0"' composer.json
rg -n '"inertiajs/inertia-laravel": "\^2\.0"' composer.json
rg -n '"@inertiajs/react": "\^2\.0\.0"' package.json
docker exec php_elitvid php artisan test
for path in / /napravleniya/skami /cart /login; do
  code=$(curl -s -o /dev/null -w "%{http_code}" "http://localhost:8080${path}")
  echo "$code $path"
  test "$code" = "200"
done
```

Expected: PHP 8.5.x, Laravel 13, both kernel files absent, green gate.

- [ ] **Step 9: Commit**

```bash
git add bootstrap/app.php bootstrap/providers.php public/index.php artisan config/app.php routes/web.php app/Http/Middleware/RedirectIfAuthenticated.php tests/Feature/Auth/AuthenticationTest.php tests/Feature/Auth/RegistrationTest.php tests/Feature/Auth/EmailVerificationTest.php
git add -u app/Http/Kernel.php app/Console/Kernel.php app/Providers/RouteServiceProvider.php app/Exceptions/Handler.php
git commit -m "$(cat <<'EOF'
refactor: boot Laravel 13 from bootstrap/app.php

Move middleware, providers, and the API rate limit out of the old kernels.
EOF
)"
```

If step 7 added `HorizonServiceProvider` to `bootstrap/providers.php`, that file is already in the `git add` above.
