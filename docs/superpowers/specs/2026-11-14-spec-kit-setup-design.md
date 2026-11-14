# Spec-kit в Elitvid и границы с документацией

## Цель

Подготовить репозиторий Elitvid v2 к работе через spec-kit, не смешав его с kit генерации документации и с черновиками `docs/superpowers/`.

В этом шаге ставится только spec-kit и короткий корневой `AGENTS.md`. Kit документации (`aidocumentation` / `AIDocumentation`) не копируется и не запускается.

## Контекст

Elitvid — Laravel 10, PHP 8.1, Docker. Подъём: `make init`, сайт `http://localhost:8080`. Подробности — `README.md`.

Сейчас в репозитории нет `AGENTS.md` и нет `.cursor/`. Есть `docs/superpowers/` — черновики обсуждений в чате, включая спеку `make init`.

Cursor всегда подмешивает корневой `AGENTS.md` и `.cursor/rules/*.mdc`. Skills из `.cursor/skills/` срабатывают по команде. Конфликт дают два всегда включённых файла с противоположными приказами, а не соседние skill.

## Что ставит spec-kit

Команда из корня репозитория:

```bash
specify init --here --force --integration cursor-agent --script sh --integration-options="--events false"
```

`--force` нужен, потому что каталог уже не пустой. Команда вливает файлы spec-kit и не переписывает код приложения. `--events false` не создаёт `.cursor/hooks.json`.

Появляются:

| Путь | Владелец | Назначение |
|---|---|---|
| `.specify/` | spec-kit | constitution, шаблоны, скрипты, служебные json |
| `.cursor/skills/speckit-*/` | spec-kit | команды `/speckit-*` |
| `.cursor/rules/specify-rules.mdc` | spec-kit | единственное всегда включённое правило spec-kit |

Каталог `specs/<фича>/` spec-kit создаёт на первую фичу (`/speckit-specify`), не на `init`. Пустую фичу ради каталога не заводить. `AGENTS.md` уже указывает этот путь.

CLI корневой `AGENTS.md` не создаёт и при последующем обновлении spec-kit его не затирает. Если CLI не принимает `--events false`, остановиться. Хуки не ставить запасным путём.

## AGENTS.md

Файл пишется вручную, один на корень репозитория. Он не повторяет `specify-rules.mdc` и не содержит правил kit документации.

Текст:

```md
# Elitvid v2

Laravel 10, PHP 8.1, Docker. Сайт: http://localhost:8080. Подъём: `make init` (см. README.md).

## Куда смотреть

- Новая фича — spec-kit: `specs/<фича>/` (spec, plan, tasks). Принципы нового кода — `.specify/memory/constitution.md`. Команды — `/speckit-*`. Корень spec-kit — этот репозиторий.
- Как система устроена сейчас — `docs/ai/` (для AI) и `docs/human/` (для человека). Пишет `/elitvid-docs` из окна родительской папки.
- Черновики обсуждений в чате — `docs/superpowers/`. В `specs/` их не переносить.

## Границы

- Код, миграции и конфиги менять по активной спеке в `specs/`.
- Пока идёт `/elitvid-docs`: код приложения, миграции и базу не менять. Базу можно только читать.
- `.cursor/skills/speckit-*` и `.specify/` обновляет spec-kit.
- Навыки и правила kit документации в этот репозиторий не копировать.
- Этот файл — единственный `AGENTS.md` репозитория сайта.
```

## Чего этот шаг не делает

- Не копирует `aidocumentation` и `AIDocumentation` в Elitvid: ни `AGENTS.md`, ни `.cursor/rules/`, ни `.cursor/skills/`.
- Не склеивает `.specify/memory/constitution.md` с будущим `CONSTITUTION.md` kit. Первый — правила нового кода. Второй — карта уже существующей системы. Позже они только ссылаются друг на друга.
- Не переносит `docs/superpowers/specs/2026-11-14-make-init-design.md` и план `make init` в `specs/`.
- Не включает хуки spec-kit.
- Не коммитит результат установки, пока это не попросили отдельно. После `specify init` смотрим `git status`.

## Как подключается документация

Окно Cursor — родительская папка `Elitvid`, не этот репозиторий. Команды документации живут в `aidocumentation` и попадают в окно ссылками. Готовые документы пишутся в `docs/ai/` и `docs/human/` этого репозитория. Правила kit в продукт не копируются. Полная схема — `2026-11-14-docs-kit-adaptation-design.md`.

`.specify/memory/constitution.md` и `docs/ai/CONSTITUTION.md` только ссылаются друг на друга.

## Проверка

После установки в корне есть `.specify/`, `.cursor/skills/speckit-plan/SKILL.md`, `.cursor/rules/specify-rules.mdc` и корневой `AGENTS.md` с текстом выше. Каталога `specs/<фича>/` ещё нет: его создаст первая фича.

Нет `.cursor/hooks.json`. Нет skill `docsdevarea`, `docsconnect` и `elitvid-docs`. В репозитории сайта один `AGENTS.md`. `docs/superpowers/` на месте. Файлы оттуда в `specs/` не скопированы.

Код приложения, `composer.json`, Docker и `README.md` эта установка не меняет. Правка корневого `.gitignore` допустима только если она игнорирует локальное состояние spec-kit. Любая другая правка этих файлов значит, что установку не оставляем.
