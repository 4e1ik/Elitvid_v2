# 🚀 Elitvid v2

## Как запустить проект

### Требования

- Docker и Docker Compose
- SQL-дамп базы с хостинга (файл `cr48940_elitvid.sql` в корне проекта)
- Файлы изображений с хостинга (см. шаг 5)

### 1. Настройка окружения

Скопируйте `.env` и укажите параметры для Docker:

```bash
cp .env.example .env
```

Минимальные значения для локального запуска:

```env
APP_URL=http://localhost:8080

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=elitvid_db
DB_USERNAME=root
DB_PASSWORD=root

REDIS_HOST=redis
```

### 2. Запуск контейнеров

```bash
make init
```

Сайт будет доступен на [http://localhost:8080](http://localhost:8080).

### 3. Установка PHP-зависимостей

```bash
make app
composer install
```

> **Важно:** Docker-образ использует PHP 8.1. Если `composer install` ругается на несовместимость версий пакетов, восстановите lock-файл, совместимый с PHP 8.1:
>
> ```bash
> git checkout c16e78f -- composer.lock
> composer install
> ```

Сообщение Xdebug `Could not connect to debugging client` можно игнорировать — на установку это не влияет.

### 4. Подготовка и импорт базы данных

Положите свежий дамп с хостинга в корень проекта как `cr48940_elitvid.sql`, затем подготовьте файл для импорта:

```bash
{
  echo "SET FOREIGN_KEY_CHECKS=0;"
  echo "SET NAMES utf8mb4;"
  cat cr48940_elitvid.sql
  echo "SET FOREIGN_KEY_CHECKS=1;"
} > cr48940_elitvid_ordered.sql
```

Создайте пустую базу и импортируйте дамп:

```bash
docker exec -i elitvid_db mysql -uroot -proot -e "DROP DATABASE IF EXISTS elitvid_db; CREATE DATABASE elitvid_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
make db-import
```

> **Не запускайте** `php artisan migrate` до импорта дампа. Миграции на пустой базе завершатся с ошибкой, а частично созданные таблицы помешают импорту (например, `Unknown column 'galleriable_id'`).
>
> Если импорт уже падал — повторите команду с `DROP DATABASE` выше и запустите `make db-import` снова.

### 5. Импорт файлов с хостинга

Дамп базы содержит только **пути** к картинкам, сами файлы в репозиторий не входят. Без них на сайте будут «битые» изображения.

Скопируйте с хостинга (через FTP, SFTP или файловый менеджер панели):

| На хостинге | Куда положить локально | Что хранится |
|-------------|------------------------|--------------|
| `storage/app/public/` | `storage/app/public/` | Загруженные через админку изображения товаров, галерей, блога (`public/images/...` в БД) |
| `public/elitvid_assets/newDesign/newDesign/imgs/` | `public/elitvid_assets/newDesign/newDesign/imgs/` | Статические изображения дизайна, коллекций, баннеров (`/elitvid_assets/...` в БД) |
| `public/elitvid_assets/newDesign/newDesign/files/` | `public/elitvid_assets/newDesign/newDesign/files/` | Дополнительные файлы (папка не в git) |

> Если не уверены, что скопировали всё — скачайте целиком каталоги `storage/app/public/` и `public/elitvid_assets/` с хостинга.

### 6. Инициализация приложения

В контейнере `php_elitvid`:

```bash
php artisan key:generate
php artisan migrate
php artisan storage:link
```

`php artisan migrate` после импорта применит только те миграции, которых ещё нет в дампе.

`php artisan storage:link` создаёт симлинк `public/storage` → `storage/app/public` — без него картинки из `storage/app/public/` не откроются в браузере.

### 7. Готово

Откройте [http://localhost:8080](http://localhost:8080).

---

## Полезные команды

| Команда | Описание |
|---------|----------|
| `make init` | Сборка и запуск Docker-контейнеров |
| `make app` | Вход в контейнер PHP (`php_elitvid`) |
| `make db-import` | Импорт `cr48940_elitvid_ordered.sql` в `elitvid_db` |

---

## Обновление данных с хостинга

1. Экспортируйте свежий дамп с хостинга → сохраните как `cr48940_elitvid.sql`
2. Скопируйте актуальные файлы изображений (шаг 5)
3. Пересоздайте `cr48940_elitvid_ordered.sql` (команда из шага 4)
4. Сбросьте локальную базу и импортируйте заново:

```bash
docker exec -i elitvid_db mysql -uroot -proot -e "DROP DATABASE IF EXISTS elitvid_db; CREATE DATABASE elitvid_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
make db-import
php artisan migrate
```

---

## 📝 Конфигурация статических страниц

Статические страницы сайта (которые не создаются динамически через админ-панель) настраиваются в файле `config/pages.php`.

### Добавление новой статической страницы

При необходимости добавить новую статическую страницу:

1. Откройте файл `config/pages.php`
2. Добавьте новую запись в массив в формате:
   ```php
   'ключ_страницы' => 'Название страницы',
   ```
3. Пример:
   ```php
   'new_page' => 'Новая страница',
   ```

**Важно:** После добавления новой страницы в конфиг, убедитесь, что соответствующие маршруты и контроллеры настроены для обработки этой страницы.

### Использование в коде

Для получения названия страницы по её ключу используйте:
```php
$pageNames = config('pages', []);
$pageName = $pageNames['ключ_страницы'] ?? 'Значение по умолчанию';
```
