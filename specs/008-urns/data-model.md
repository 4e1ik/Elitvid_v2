# Data Model: Урны

## Product (есть)

`product_type` получает значение `urn`. Связь `urn(): hasOne(Urn)`.

## Urn (новая, таблица `urns`)

| Поле | Тип | Правило |
|---|---|---|
| id | bigint | PK |
| product_id | bigint | FK `products.id`, `onDelete cascade`, индекс |
| data | json, null | массив вариантов `{size, weight, price}`; хотя бы одно поле в одном варианте при создании |
| material | string(255), null | обязательно в форме, 3–100 символов |
| timestamps | | |

## Image (есть)

Фото урны — `images` с `imageable = Product`; `color`, `texture` необязательны.

## PageContent (есть)

Строка `page = 'urns'`: SEO-текст и галерея «Примеры работ».
