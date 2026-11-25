# Data Model: Объединение квадратных и прямоугольных кашпо

Схема не меняется. Меняются только значения.

## pots.collection

| Было | Станет | Сегмент адреса |
|---|---|---|
| `Round` | `Round` | `kruglye` |
| `Square` | `Square_rectangular` | `kvadratnye-i-pryamougolnye` |
| `Rectangular` | `Square_rectangular` | `kvadratnye-i-pryamougolnye` |

## page_contents.page, static_images.page

| Было | Станет |
|---|---|
| `rectangular_pots` | `square_rectangular_pots` |
| `square_pots` | без изменений (не используется) |

## pots_square_backup (служебная, только на время между up и down)

| Поле | Тип | Смысл |
|---|---|---|
| `pot_id` | bigint | id строки `pots`, которая была `Square` |

## Миграция

- `up()`: создать `pots_square_backup` и сохранить в неё id строк `Square`. Перевести `Square` и `Rectangular` в `Square_rectangular`. Переименовать `page` в двух таблицах. Повторный запуск ничего не ломает: условия `where` отбирают только старые значения.
- `down()`: перевести всё `Square_rectangular` обратно в `Rectangular`, строки из бэкапа — в `Square`. Вернуть `page`. Удалить `pots_square_backup`.
