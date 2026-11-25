# Research: 010-order-email

- **Decision**: новый `OrderMail`, а не повторное использование `FeedbackMail`.
  **Rationale**: `FeedbackMail` ждёт массив формы (`country`, `phone` отдельно, вложение) и не знает про товары; правка затронула бы форму заявки (FR-006).
- **Decision**: адрес `el_vid@mail.ru` литералом в `CartService` с комментарием-ссылкой на `MailController::send`.
  **Rationale**: общий конфиг потребовал бы менять `MailController`. Изменение адреса — правка в двух местах; это фиксируется в комментарии.
  **Alternatives**: `config('mail.orders_to')` — отложено до задачи на смену адреса.
- **Decision**: письмо после транзакции сохранения, сбой ловится `\Throwable`, журнал `Log::error`.
  **Rationale**: заказ не теряется при недоступной почте (решение пользователя 2026-11-25).
- **Decision**: признак `mail_failed` (default `false`), а не `mail_sent`.
  **Rationale**: старые заказы без признака не помечаются (FR-005) без заполнения данных.
- **Decision**: синхронная отправка.
  **Rationale**: так работает форма заявки; очередь Horizon для писем сейчас не используется.
