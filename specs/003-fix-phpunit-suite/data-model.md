# Data Model: Рабочий набор автотестов

Новых таблиц и полей нет. Ниже — какие записи тесты создают в `elitvid_testing` и по каким правилам.

## Пользователь (`users`) — через UserFactory

| Поле | Значение в фабрике | Правило |
|------|--------------------|---------|
| `username` | случайное имя | обязательно |
| `email` | уникальный безопасный email | обязательно, уникально |
| `password` | `password` | модель хеширует сама (cast `hashed`) |
| `role` | `viewer` | одно из `admin`, `manager`, `viewer` |
| `active` | `true` | boolean |

Где используется:

- `AuthenticationTest`: пользователь с ролью по умолчанию.
- `CartOrderTest`: `role = admin`, иначе `/admin/orders` недоступен (`role.access:admin,manager`).

## Товар (`products`) — прямо в CartOrderTest

| Поле | CUBE | KOLONNA |
|------|------|---------|
| `name` | `CUBE` | `KOLONNA` |
| `slug` | `cube` | `kolonna` (обязательно: миграция `2026_02_05_100001` делает `slug` NOT NULL) |
| `product_type` | `pot` | `bench` |
| `active` | `true` | `true` |

Доступен для заказа, только если `active`, `deleted_at` пустой и `product_type` из `bench|pot` (`CartService::lines()`).

## Заказ и позиции (`orders`, `order_items`)

Создаёт сам сайт при `POST /cart/order`. Тест проверяет:

- в `orders`: `name`, `email`, `corporation_name`, `comment`;
- в `order_items`: `product_id` = id созданного товара, `product_name`, `quantity` (CUBE × 2, KOLONNA × 1).
