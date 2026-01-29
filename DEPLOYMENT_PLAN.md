# План деплоя: Слияние dev в main

## ⚠️ ВАЖНО: Перед началом

1. **Сделать полный бэкап БД**
2. **Протестировать на staging окружении**
3. **Убедиться, что все миграции проходят успешно**

---

## 📋 Порядок выполнения миграций

### Этап 1: Структурные миграции (создание таблиц и полей)

1. ✅ `2026_01_24_120000_create_page_contents_table.php`
   - Создает таблицу `page_contents`
   - Поля: `page`, `meta_title`, `meta_description`, `category_description`

2. ✅ `2026_01_16_100005_update_galleries_table_for_polymorphic_relation.php`
   - Добавляет поля `galleriable_id` и `galleriable_type` в таблицу `galleries`

3. ✅ `2026_01_24_150000_migrate_gallery_images_to_images_table.php`
   - Переносит изображения из `gallery_images` в `images` с полиморфными связями

4. ✅ `2026_01_24_160000_consolidate_galleries_by_type.php`
   - Объединяет дублирующиеся галереи по типу

5. ✅ `2026_01_24_170000_add_unique_index_to_galleries_type.php`
   - Добавляет уникальный индекс на поле `type` в таблице `galleries`

### Этап 2: Миграция данных (перенос из старых таблиц)

6. ✅ `2026_01_28_180000_migrate_meta_tags_to_page_contents.php`
   - Переносит данные из `meta_tags` → `page_contents`
   - Обновляет `meta_title` и `meta_description`
   - **ВАЖНО**: Поддерживает оба варианта названия таблицы (`meta_tags` и `metatags`)

7. ✅ `2026_01_28_190000_migrate_categories_to_page_contents.php` ⭐ **НОВАЯ**
   - Переносит данные из `categories` → `page_contents`
   - Обновляет `category_description`
   - Обновляет только пустые поля (не перезаписывает существующие данные)

### Этап 3: Связывание галерей

8. ✅ `2026_01_24_140000_link_existing_galleries_to_page_contents.php`
   - Связывает существующие галереи с `PageContent` через полиморфную связь

---

## 🌱 Порядок выполнения сидеров

### После всех миграций:

1. ✅ `PageContentSeeder`
   - Создает записи для всех страниц из `config('pages')`
   - Заполняет пустые поля данными из старых таблиц (если миграции еще не выполнили это)
   - Связывает галереи с `PageContent`

**Команда:**
```bash
php artisan db:seed --class=PageContentSeeder
```

---

## 🔍 Проверка после деплоя

### 1. Проверка данных

```sql
-- Проверить, что все страницы есть в page_contents
SELECT COUNT(*) FROM page_contents;
-- Должно быть столько же, сколько страниц в config('pages') (15 страниц)

-- Проверить, что данные перенесены
SELECT page, 
       CASE WHEN meta_title IS NOT NULL THEN 'OK' ELSE 'EMPTY' END as meta_title_status,
       CASE WHEN meta_description IS NOT NULL THEN 'OK' ELSE 'EMPTY' END as meta_description_status,
       CASE WHEN category_description IS NOT NULL THEN 'OK' ELSE 'EMPTY' END as category_description_status
FROM page_contents;

-- Проверить связь галерей
SELECT pc.page, g.type, g.id as gallery_id
FROM page_contents pc
LEFT JOIN galleries g ON g.galleriable_id = pc.id AND g.galleriable_type = 'App\\Models\\PageContent';
```

### 2. Проверка работы сайта

- [ ] Главная страница загружается
- [ ] Мета-теги отображаются в `<title>` и `<meta name="description">`
- [ ] Описания категорий отображаются на страницах
- [ ] Галереи отображаются на главной странице
- [ ] Все страницы продуктов работают
- [ ] Админ-панель: страница редактирования контента работает

---

## ⚠️ Потенциальные проблемы и решения

### Проблема 1: Таблица `meta_tags` называется `metatags` (без подчеркивания)
**Решение**: Миграция `2026_01_28_180000` поддерживает оба варианта

### Проблема 2: Некоторые страницы отсутствуют в `page_contents`
**Решение**: `PageContentSeeder` создаст недостающие записи

### Проблема 3: Галереи не связаны с `PageContent`
**Решение**: Миграция `2026_01_24_140000` и `PageContentSeeder` свяжут их

### Проблема 4: Пустые `category_description` после миграции
**Решение**: `PageContentSeeder` заполнит их из старой таблицы `categories`

---

## 📝 Команды для деплоя

```bash
# 1. Бэкап БД
mysqldump -u user -p database_name > backup_$(date +%Y%m%d_%H%M%S).sql

# 2. Переключиться на ветку dev
git checkout dev
git pull origin dev

# 3. Запустить миграции
php artisan migrate

# 4. Запустить сидер
php artisan db:seed --class=PageContentSeeder

# 5. Очистить кэш
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# 6. Проверить работу сайта
```

---

## 🔄 Откат (если что-то пошло не так)

### Вариант 1: Откат миграций
```bash
php artisan migrate:rollback --step=8
```

### Вариант 2: Восстановление из бэкапа
```bash
mysql -u user -p database_name < backup_YYYYMMDD_HHMMSS.sql
```

**ВАЖНО**: Старые таблицы `meta_tags` и `categories` НЕ удаляются, данные остаются нетронутыми.

---

## ✅ Чеклист перед деплоем

- [ ] Бэкап БД создан
- [ ] Протестировано на staging
- [ ] Все миграции проходят успешно
- [ ] Сидеры работают корректно
- [ ] Проверены все страницы на сайте
- [ ] Проверена админ-панель
- [ ] Команда готова к деплою

---

## 📊 Ожидаемый результат

После успешного деплоя:
- ✅ Все данные из `meta_tags` и `categories` перенесены в `page_contents`
- ✅ Все страницы имеют записи в `page_contents`
- ✅ Галереи связаны с `PageContent` через полиморфную связь
- ✅ Сайт работает без ошибок
- ✅ Админ-панель: единая страница для управления контентом

---

## 🎯 Итоговый порядок выполнения

1. **Миграции** (в хронологическом порядке):
   ```
   2026_01_24_120000_create_page_contents_table.php
   2026_01_16_100005_update_galleries_table_for_polymorphic_relation.php
   2026_01_24_150000_migrate_gallery_images_to_images_table.php
   2026_01_24_160000_consolidate_galleries_by_type.php
   2026_01_24_170000_add_unique_index_to_galleries_type.php
   2026_01_28_180000_migrate_meta_tags_to_page_contents.php
   2026_01_28_190000_migrate_categories_to_page_contents.php ⭐ НОВАЯ
   2026_01_24_140000_link_existing_galleries_to_page_contents.php
   ```

2. **Сидеры**:
   ```
   PageContentSeeder
   ```

3. **Очистка кэша**

4. **Проверка работы**

---

**Удачи с деплоем! 🚀**
