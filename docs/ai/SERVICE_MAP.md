# Elitvid — карта сервиса

Только точки входа, которые есть в коде.

## Публичный сайт

| Часть | Где |
|---|---|
| Маршруты | `routes/web.php` |
| Главная, блог, направления, декор | `app/Http/Controllers/MainController.php` |
| Общий каркас | `resources/views/layouts/elitvid/elitvid.blade.php` |

## Каталог скамеек

| Часть | Где |
|---|---|
| Сайт | `app/Http/Controllers/BenchController.php` |
| Админка коллекций | `app/Http/Controllers/Admin/BenchController.php` |
| Товар и коллекция | `app/Models/Product.php`, `app/Models/Bench.php` |

## Каталог кашпо

| Часть | Где |
|---|---|
| Сайт | `app/Http/Controllers/PotController.php` |
| Админка форм | `app/Http/Controllers/Admin/PotController.php` |
| Товар | `app/Models/Product.php`, `app/Models/Pot.php` |

## Болларды и ограждения

| Часть | Где |
|---|---|
| Сайт | `app/Http/Controllers/BollardsAndFencingController.php` |

## Статические страницы направлений

| Часть | Где |
|---|---|
| Сайт по slug | `app/Http/Controllers/StaticPagesController.php` |
| Админка | `app/Http/Controllers/Admin/StaticPageController.php` |
| Модель | `app/Models/StaticPage.php` |

## Контент фиксированных страниц

| Часть | Где |
|---|---|
| Ключи | `config/pages.php` |
| Админка | `app/Http/Controllers/Admin/PageContentController.php` |
| Модель | `app/Models/PageContent.php` |
| Картинки страниц | `app/Http/Controllers/Admin/StaticImagesController.php`, `app/Models/StaticImages.php` |

## Блог

| Часть | Где |
|---|---|
| Сайт | `MainController` (`blog_posts`, `show_blog_post`) |
| Админка | `app/Http/Controllers/Admin/BlogController.php` |
| Модель | `app/Models/Blog.php` |

## Заявки

| Часть | Где |
|---|---|
| Приём формы | `POST /send_mail`, `app/Http/Controllers/MailController.php` |
| Проверка полей | `app/Http/Requests/MailRequest.php` |
| Список в админке | `app/Http/Controllers/Admin/MailController.php` |
| Запись | `app/Models/Mail.php` |
| Файл вложения | `app/Http/Controllers/MailAttachmentController.php` |

## Админка и пользователи

| Часть | Где |
|---|---|
| Вход | `GET|POST /login`, `app/Http/Controllers/Admin/Auth/LoginController.php` |
| Сводка | `app/Http/Controllers/Admin/AdminController.php` |
| Пользователи | `app/Http/Controllers/Admin/UserController.php` |
| Меню | `resources/views/layouts/elitvid/admin/admin.blade.php` |
