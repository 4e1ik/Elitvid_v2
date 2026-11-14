# Docs kit adaptation Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** В общем окне `Elitvid` одновременно доступны команды spec-kit и одна команда `/elitvid-docs`, а готовые документы потом пишутся в git сайта.

**Architecture:** Spec-kit ставится в `Elitvid_v2`. Kit в `aidocumentation` переписывается под Elitvid: Guru-навыки удаляются, остаётся `/elitvid-docs`. Скрипт `link-workspace.sh` создаёт в родительской папке символические ссылки на оба набора команд и записывает родительский `AGENTS.md` из шаблона. Текст `docs/ai/` и `docs/human/` этот план не пишет.

**Tech Stack:** specify-cli через `uv`, bash, символические ссылки, Cursor skills (Markdown), graphify CLI уже установлен в `~/.local/bin/graphify`.

## Global Constraints

- Окно Cursor — `/Users/artemi/projects/Elitvid`. Эта папка не git.
- Корень spec-kit — `Elitvid_v2`. Фичи — `Elitvid_v2/specs/<фича>/`.
- `Elitvid/.cursor/skills/` и `Elitvid/.cursor/rules/` — обычные каталоги. Ссылками являются записи внутри них.
- Всегда включено только `specify-rules.mdc`. Запрет менять код и писать в базу живёт внутри `/elitvid-docs`.
- Навыки документации в `Elitvid_v2/.cursor` не копировать.
- `.specify/memory/constitution.md` и будущий `docs/ai/CONSTITUTION.md` не склеивать.
- `docs/superpowers/` в `specs/` не переносить.
- Код приложения, `composer.json`, Docker и `README.md` сайта не менять.
- Каталог `specs/<фича>/` не создавать.
- `docs/ai/` и `docs/human/` не писать. Их пишет только будущий запуск `/elitvid-docs` после отдельного «да».
- Figma, Grafana, Jira и Confluence не подключать.
- `aidocumentation/.env` не открывать, не печатать и не коммитить.
- Git commit не делать, пока это не попросили отдельно.
- Если `specify init` не принимает `--events false`, остановиться. `.cursor/hooks.json` не создавать другим путём.
- Если в родительской папке появились обычные каталоги `specs/` или `.specify`, удалить их и остановить задачу.

---

### Task 1: Spec-kit в Elitvid_v2

**Files:**
- Create: `Elitvid_v2/AGENTS.md`
- Create by CLI: `Elitvid_v2/.specify/`, `Elitvid_v2/.cursor/skills/speckit-*/`, `Elitvid_v2/.cursor/rules/specify-rules.mdc`
- Test: проверки `test` и `git status` ниже

**Interfaces:**
- Consumes: спека `Elitvid_v2/docs/superpowers/specs/2026-11-14-spec-kit-setup-design.md`
- Produces: каталог `Elitvid_v2/.cursor/skills/speckit-plan/` с файлом `SKILL.md`, файл `Elitvid_v2/.cursor/rules/specify-rules.mdc`, каталог `Elitvid_v2/.specify/`. Без них Task 5 останавливается.

- [ ] **Step 1: Поставить CLI, если его нет**

Run: `command -v specify || true`

Если команда ничего не напечатала:

```bash
uv tool install specify-cli
specify version
```

Expected: `specify version` печатает версию и заканчивается с кодом 0. Сеть нужна. Если установка падает — остановиться и показать ошибку, другой установщик не подбирать.

- [ ] **Step 2: Инициализировать spec-kit**

Рабочий каталог: `/Users/artemi/projects/Elitvid/Elitvid_v2`.

```bash
specify init --here --force --integration cursor-agent --script sh --integration-options="--events false"
```

Expected: код 0. Если CLI пишет, что `--events false` неизвестен — остановиться, `.cursor/hooks.json` не создавать.

- [ ] **Step 3: Записать AGENTS.md сайта**

Содержимое `Elitvid_v2/AGENTS.md` целиком:

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

- [ ] **Step 4: Проверить установку**

```bash
test -d .specify
test -f .cursor/skills/speckit-plan/SKILL.md
test -f .cursor/rules/specify-rules.mdc
test ! -f .cursor/hooks.json
test ! -d .cursor/skills/docsdevarea
test ! -d .cursor/skills/docsconnect
test ! -d .cursor/skills/elitvid-docs
test ! -d specs
git status --short
```

Expected: четыре `test` на наличие проходят, четыре `test !` проходят, каталога `specs/` нет. В `git status` нет правок `composer.json`, `docker-compose.yml`, `README.md` и каталога `app/`. Правка `.gitignore` допустима только строками про локальное состояние spec-kit. Любая другая правка этих файлов — установку не оставлять: вернуть чужие файлы и остановить задачу.

В родительской папке `/Users/artemi/projects/Elitvid` не должно появиться обычных каталогов `.specify` и `specs`. Если появились — удалить и остановить задачу.

Не коммитить.

### Task 2: Убрать Guru-контур из kit

**Files:**
- Delete: перечисленные ниже пути внутри `/Users/artemi/projects/Elitvid/aidocumentation`
- Modify: ничего, пока только удаление

**Interfaces:**
- Consumes: ничего из Task 1
- Produces: в kit нет навыков `docsdevarea`, `confluence-publish`, `vue-screen-map` и нет `.cursor/mcp.json`

- [ ] **Step 1: Удалить файлы и каталоги**

Из `/Users/artemi/projects/Elitvid/aidocumentation`:

```bash
rm -rf \
  .cursor/skills/docsdevarea \
  .cursor/skills/docsdevarea-screen \
  .cursor/skills/docsdevarea-main \
  .cursor/skills/confluence-publish \
  .cursor/skills/compass-bootstrap \
  .cursor/skills/docs-update-rules \
  .cursor/skills/docs-structure \
  .cursor/skills/vue-screen-map \
  .cursor/skills/laravel-business-logic-search \
  .cursor/skills/laravel-api-extraction \
  .cursor/skills/diagram-conventions \
  .cursor/mcp
rm -f \
  .cursor/rules/kit-safety.mdc \
  .cursor/rules/paymentguru-graphify.mdc \
  .cursor/rules/paymentguru-context.mdc \
  .cursor/rules/chat-backend-context.mdc \
  .cursor/mcp.json \
  docs/sync-ai-after-main.md \
  docs/stand-db-readonly-for-devops.md \
  docs/graphify-ci-for-devops.md
```

Файл `.env` не удалять и не читать. `.cursor/skills/repos-map/` пока оставить: его заменит Task 4.

- [ ] **Step 2: Проверить, что Guru-контур исчез**

```bash
test ! -d .cursor/skills/docsdevarea
test ! -d .cursor/skills/docsdevarea-screen
test ! -d .cursor/skills/docsdevarea-main
test ! -d .cursor/skills/confluence-publish
test ! -d .cursor/skills/vue-screen-map
test ! -f .cursor/rules/kit-safety.mdc
test ! -f .cursor/mcp.json
test ! -d .cursor/mcp
test ! -d .cursor/rules || test -z "$(find .cursor/rules -type f -print)"
```

Expected: все команды заканчиваются с кодом 0. Не коммитить.

### Task 3: Навык `/elitvid-docs` и шаблоны

**Files:**
- Create: `aidocumentation/.cursor/skills/elitvid-docs/SKILL.md`
- Create: `aidocumentation/.cursor/skills/elitvid-docs/templates/CONSTITUTION.md`
- Create: `aidocumentation/.cursor/skills/elitvid-docs/templates/SERVICE_MAP.md`

**Interfaces:**
- Consumes: путь сайта `Elitvid_v2`, локальная база `elitvid_db`
- Produces: команда `/elitvid-docs`. Позже она пишет только файлы из списка ниже и только после «да».

- [ ] **Step 1: Записать SKILL.md**

Содержимое `aidocumentation/.cursor/skills/elitvid-docs/SKILL.md`:

```md
---
name: elitvid-docs
description: Use when the user runs /elitvid-docs to write or patch Elitvid system docs for AI and for a human reader.
disable-model-invocation: true
---

# /elitvid-docs

**Announce:** `📎 [SKILL] Загружен: /elitvid-docs`

Сайт — соседний каталог `Elitvid_v2` от родительской папки окна. Если каталога нет, остановиться: `⚠ /elitvid-docs: не хватает — Elitvid_v2`.

Шаблоны: `.cursor/skills/elitvid-docs/templates/CONSTITUTION.md` и `SERVICE_MAP.md`.

## Запрещено до и после «да»

- Менять код приложения, миграции, конфиги, `composer.json`, Docker и `README.md` сайта.
- Писать в базу: `INSERT`, `UPDATE`, `DELETE`, сиды, `artisan` с записью.
- Выдумывать эндпоинты, роли, поля и пункты меню.
- Писать `docs/ai/` и `docs/human/` до «да», «ок» или «план верный». Молчание планом не считается.
- Копировать пароль из `.env` в чат, в markdown и на скриншоты.
- Подключать Figma, Grafana, Jira и Confluence.
- Создавать `specs/<фича>/` и править `.specify/`.

## Куда писать

Только эти пути внутри `Elitvid_v2`:

| Файл | Содержание |
|---|---|
| `docs/ai/CONSTITUTION.md` | продукт, стек, роли, куда смотреть в коде, одна ссылка на `.specify/memory/constitution.md` |
| `docs/ai/SERVICE_MAP.md` | модули и точки входа по коду |
| `docs/ai/graphify-out/` | вывод CLI `graphify`, если он установлен |
| `docs/human/obzor.md` | сайт целиком: главная, направления, статические страницы, как контент из админки попадает на сайт |
| `docs/human/katalog.md` | скамейки, кашпо, болларды и ограждения |
| `docs/human/blog.md` | блог |
| `docs/human/zayavki.md` | форма на сайте и заявки в админке |
| `docs/human/admin.md` | разделы админки и роли по маршрутам |

Язык обоих слоёв — русский. Слой AI короткий. Слой для человека объясняет поведение предложениями. Отдельного файла на URL нет. Статические страницы и контент страниц входят в `obzor.md` и `admin.md`.

Роли читать из маршрутов и middleware в момент запуска. Матрицу прав не брать из этой инструкции как из факта.

Уже существующий файл править по затронутым разделам. Полная перезапись — только если файла ещё нет.

## Порядок

1. Прочитать код `Elitvid_v2`.
2. Прочитать базу только `SELECT`. Параметры `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, `DB_PORT` из `Elitvid_v2/.env`. Порт по умолчанию `3306`. Подключение с машины пользователя на `127.0.0.1`. `DB_HOST=mysql` не использовать: это имя сервиса Docker. Нет подключения — в план одна фраза, что база не прочитана и факты возьмутся из кода.
3. Показать план: какие файлы из таблицы будут созданы или какой раздел будет обновлён, будут ли скриншоты и будет ли граф.
4. Ждать «да», «ок» или «план верный». На «нет» переписать план и снова ждать. Файлы не писать.
5. После «да» записать markdown.
6. Скриншоты снять с `http://localhost:8080` и положить рядом с человеческим файлом, который они иллюстрируют. Кадра на каждый URL нет. Сайт отвечает и логин админки есть — два кадра: публичный сайт и главная админки. Дополнительный кадр допустим, если без него раздел непонятен. Нет логина — только публичный кадр, пропуск админки назвать в ответе. Сайт не отвечает — кадров нет, это тоже назвать. Логин спросить один раз в чате и никуда не записывать.
7. Граф. Если `command -v graphify` пуст — сказать, что нужен CLI `graphify`, каталог графа не создавать и не заполнять вручную. Markdown, уже подтверждённый планом, оставить. Если CLI есть, из корня `Elitvid_v2`:

```bash
graphify extract . --no-viz --code-only
graphify cluster-only . --no-viz --no-label
```

Дождаться `graphify-out/graph.json`. Нет файла — остановиться, содержимое не подменять. Есть файл — переместить каталог `graphify-out` в `docs/ai/graphify-out`, заменив прежний каталог графа. В git граф добавлять только по отдельной просьбе закоммитить. Перед этим сравнить размер `docs/ai/graphify-out/` с суммарным размером markdown в `docs/ai/` и `docs/human/`. Каталог графа больше — в git не добавлять и сказать об этом.

Факты только из кода, маршрутов и прочитанной базы.
```

- [ ] **Step 2: Записать шаблон CONSTITUTION**

Содержимое `aidocumentation/.cursor/skills/elitvid-docs/templates/CONSTITUTION.md`:

```md
# Elitvid — карта системы для AI

Компактный контекст текущей системы. Правила нового кода — `Elitvid_v2/.specify/memory/constitution.md`. Эти два файла не склеивать.

## Что это

<1–3 предложения из README и кода. Без выдумок.>

## Стек

- <факты из composer.json и README>

## Роли

<роли из маршрутов и middleware>

## Куда смотреть в коде

| Слой | Путь | Роль |
|---|---|---|
| <как в репозитории> | | |

## Документы

| Слой | Путь |
|---|---|
| Эта карта | `docs/ai/CONSTITUTION.md` |
| Точки входа | `docs/ai/SERVICE_MAP.md` |
| Граф | `docs/ai/graphify-out/` |
| Текст для человека | `docs/human/` |
```

- [ ] **Step 3: Записать шаблон SERVICE_MAP**

Содержимое `aidocumentation/.cursor/skills/elitvid-docs/templates/SERVICE_MAP.md`:

```md
# Elitvid — карта сервиса

Только точки входа, которые видны в коде. Модуль без файла или класса не добавлять.

## Модули

<!-- Повторять блок только для модуля, который есть в коде.

## <имя>

| Часть | Где |
|---|---|
| UI / контроллер / модель | путь |
-->
```

- [ ] **Step 4: Проверить навык**

```bash
test -f .cursor/skills/elitvid-docs/SKILL.md
test -f .cursor/skills/elitvid-docs/templates/CONSTITUTION.md
test -f .cursor/skills/elitvid-docs/templates/SERVICE_MAP.md
grep -q 'name: elitvid-docs' .cursor/skills/elitvid-docs/SKILL.md
grep -q '127.0.0.1' .cursor/skills/elitvid-docs/SKILL.md
grep -q 'docs/human/admin.md' .cursor/skills/elitvid-docs/SKILL.md
grep -q '.specify/memory/constitution.md' .cursor/skills/elitvid-docs/templates/CONSTITUTION.md
```

Expected: код 0 у каждой команды. Не коммитить.

### Task 4: Инструкции kit и карта репозитория

**Files:**
- Modify: `aidocumentation/AGENTS.md`
- Modify: `aidocumentation/README.md`
- Modify: `aidocumentation/docs/instrukciya.md`
- Modify: `aidocumentation/.env.example`
- Modify: `aidocumentation/.cursor/skills/repos-map/SKILL.md`
- Create: `aidocumentation/templates/workspace-AGENTS.md`

**Interfaces:**
- Consumes: команда `/elitvid-docs` из Task 3
- Produces: шаблон `aidocumentation/templates/workspace-AGENTS.md`, который Task 5 копирует в `Elitvid/AGENTS.md`

- [ ] **Step 1: Шаблон родительского AGENTS.md**

Содержимое `aidocumentation/templates/workspace-AGENTS.md`:

```md
# Elitvid

Окно Cursor — эта папка. Сайт — `Elitvid_v2` (Laravel 10, PHP 8.1, Docker, http://localhost:8080, подъём `make init`). Команды документации — репозиторий `aidocumentation`.

## Куда смотреть

- Новая фича сайта — spec-kit в `Elitvid_v2`: `specs/<фича>/`. Принципы нового кода — `Elitvid_v2/.specify/memory/constitution.md`. Команды — `/speckit-*`. Корень spec-kit — `Elitvid_v2`.
- Как система устроена сейчас — `Elitvid_v2/docs/ai/` (для AI) и `Elitvid_v2/docs/human/` (для человека). Пишет `/elitvid-docs`.
- Черновики обсуждений — `Elitvid_v2/docs/superpowers/`. В `specs/` их не переносить.

## Границы

- Пока идёт `/elitvid-docs`: код приложения, миграции и базу не менять. Базу `elitvid_db` можно только читать (`SELECT`).
- Менять код и базу можно задачей spec-kit по спеке в `Elitvid_v2/specs/`.
- `.specify/` и `.cursor/skills/speckit-*` внутри `Elitvid_v2` обновляет spec-kit.
- Команды документации обновляет репозиторий `aidocumentation`. В `Elitvid_v2` их не копировать.
- Всегда включённое правило окна — только правило spec-kit. Запреты документации включены внутри `/elitvid-docs`.
```

- [ ] **Step 2: AGENTS.md kit**

Содержимое `aidocumentation/AGENTS.md`:

```md
# AGENTS — kit документации Elitvid

Это исходник команды `/elitvid-docs`, не сайт. Чат открывать из родительской папки `Elitvid`, где рядом лежат `Elitvid_v2` и `aidocumentation`.

## Запрещено

- Менять код, миграции, конфиги и `README.md` сайта. Читать код для фактов можно.
- Во время `/elitvid-docs` писать в `elitvid_db`. Только `SELECT`.
- Писать документы до «да» на план файлов.
- `git push` не делать. Commit — только если явно попросили.
- Подключать Figma, Grafana, Jira и Confluence.

## Куда пишется результат

После «да» команда пишет в `Elitvid_v2/docs/ai/` и `Elitvid_v2/docs/human/`. В этот репозиторий готовые документы сайта не класть.
```

- [ ] **Step 3: README.md kit**

Содержимое `aidocumentation/README.md`:

```md
# Kit документации Elitvid

Чат открывают в папке, где рядом лежат `Elitvid_v2` и `aidocumentation`. Из одной только папки сайта или одной только этой папки команды окна не видны.

## Связать окно

После `specify init` в `Elitvid_v2`:

```bash
sh scripts/link-workspace.sh
```

Скрипт создаёт ссылки в родительской папке и записывает её `AGENTS.md` из `templates/workspace-AGENTS.md`. Повторить скрипт после обновления spec-kit или этого kit.

## Команда

В чате окна: `/elitvid-docs`.

Агент сначала присылает план файлов. Пока в чате нет «да», документы не пишутся. Результат появляется в `Elitvid_v2/docs/ai/` и `Elitvid_v2/docs/human/`.

База читается из `Elitvid_v2/.env`, только `SELECT`, с `127.0.0.1`. Пароль в чат не копировать.
```

- [ ] **Step 4: Инструкция**

Содержимое `aidocumentation/docs/instrukciya.md`:

```md
# Как обновить документацию Elitvid

## 1. Открыть окно

File → Open Folder → папка, в которой рядом лежат `Elitvid_v2` и `aidocumentation`.

Если команды не видны, в терминале из `aidocumentation` выполнить `sh scripts/link-workspace.sh` и открыть ту же папку снова.

## 2. Запустить

В чат, не в терминал:

```
/elitvid-docs
```

## 3. Ответить на план

План про этот сайт — ответить `да`. План не тот — ответить `нет` и одной фразой, что исправить. Пока нет «да», файлы не пишутся.

## 4. Где смотреть результат

| Что | Путь |
|---|---|
| Контекст для AI | `Elitvid_v2/docs/ai/` |
| Текст для человека | `Elitvid_v2/docs/human/` |

Пароль базы и пароль админки в эти файлы не попадают.
```

- [ ] **Step 5: Пример окружения**

Содержимое `aidocumentation/.env.example`:

```env
# Команда /elitvid-docs читает базу из Elitvid_v2/.env.
# Этот файл паролей не хранит. Grafana, Jira и Confluence не используются.
```

Существующий `aidocumentation/.env` не открывать и не менять.

- [ ] **Step 6: Карта репозиториев**

Содержимое `aidocumentation/.cursor/skills/repos-map/SKILL.md`:

```md
---
name: repos-map
description: Use when /elitvid-docs needs the product folder name for Elitvid.
disable-model-invocation: true
---

# Карта репозиториев

**Announce:** `📎 [SKILL] Загружен: .cursor/skills/repos-map/SKILL.md`

Одна продуктовая строка. Сам kit в таблицу не входит.

| Папка | RepoName | Стек | Зона |
|---|---|---|---|
| `Elitvid_v2` | Elitvid | laravel | сайт и админка |

Документы пишутся в `Elitvid_v2/docs/ai/` и `Elitvid_v2/docs/human/`.
```

- [ ] **Step 7: Проверить тексты**

```bash
grep -q '/elitvid-docs' AGENTS.md README.md docs/instrukciya.md templates/workspace-AGENTS.md
grep -q 'elitvid_db' templates/workspace-AGENTS.md
test ! -f .cursor/mcp.json
! grep -R -n -E 'GURU|grafana|confluence|paymentguru|guru-docs' \
  AGENTS.md README.md docs/instrukciya.md .env.example \
  templates/workspace-AGENTS.md \
  .cursor/skills/repos-map/SKILL.md \
  .cursor/skills/elitvid-docs/SKILL.md
```

Expected: код 0. Не коммитить.

### Task 5: Ссылки общего окна

**Files:**
- Create: `aidocumentation/scripts/link-workspace.sh`
- Create: `aidocumentation/scripts/link-workspace-test.sh`
- Create at runtime: `/Users/artemi/projects/Elitvid/AGENTS.md`, ссылки в `/Users/artemi/projects/Elitvid/.cursor/` и `/Users/artemi/projects/Elitvid/.specify`
- Test: `sh scripts/link-workspace-test.sh`

**Interfaces:**
- Consumes: `Elitvid_v2/.cursor/skills/speckit-plan/SKILL.md` из Task 1, навык `elitvid-docs` из Task 3, шаблон из Task 4
- Produces: в окне `Elitvid` ссылки `speckit-*`, `elitvid-docs`, `repos-map`, `specify-rules.mdc`, `.specify`, и файл `AGENTS.md`

- [ ] **Step 1: Записать тест**

Содержимое `aidocumentation/scripts/link-workspace-test.sh`:

```sh
#!/bin/sh
set -eu
SCRIPT_DIR=$(CDPATH= cd -- "$(dirname "$0")" && pwd)
KIT=$(CDPATH= cd -- "$SCRIPT_DIR/.." && pwd)

fail() { echo "FAIL: $1" >&2; exit 1; }

tmp=$(mktemp -d)
trap 'rm -rf "$tmp"' EXIT

# Нет spec-kit — скрипт обязан остановиться и ничего не создать.
if sh "$SCRIPT_DIR/link-workspace.sh" "$tmp"; then
  fail "missing speckit-plan should exit non-zero"
fi
if [ -e "$tmp/AGENTS.md" ] || [ -e "$tmp/.specify" ]; then
  fail "failed run created window files"
fi

mkdir -p "$tmp/Elitvid_v2/.cursor/skills/speckit-plan" \
  "$tmp/Elitvid_v2/.cursor/rules" \
  "$tmp/Elitvid_v2/.specify/memory"
printf 'skill\n' > "$tmp/Elitvid_v2/.cursor/skills/speckit-plan/SKILL.md"
printf 'rule\n' > "$tmp/Elitvid_v2/.cursor/rules/specify-rules.mdc"
printf 'constitution\n' > "$tmp/Elitvid_v2/.specify/memory/constitution.md"

sh "$SCRIPT_DIR/link-workspace.sh" "$tmp"

[ -L "$tmp/.specify" ] || fail ".specify is not a symlink"
[ -L "$tmp/.cursor/rules/specify-rules.mdc" ] || fail "specify-rules is not a symlink"
[ -L "$tmp/.cursor/skills/speckit-plan" ] || fail "speckit-plan is not a symlink"
[ -L "$tmp/.cursor/skills/elitvid-docs" ] || fail "elitvid-docs is not a symlink"
[ -L "$tmp/.cursor/skills/repos-map" ] || fail "repos-map is not a symlink"
[ -f "$tmp/.cursor/skills/speckit-plan/SKILL.md" ] || fail "speckit-plan target missing"
[ -f "$tmp/.cursor/skills/elitvid-docs/SKILL.md" ] || fail "elitvid-docs target missing"
grep -q 'Корень spec-kit' "$tmp/AGENTS.md" || fail "AGENTS.md missing spec-kit root"
rules=$(find "$tmp/.cursor/rules" -mindepth 1 -maxdepth 1 | wc -l | tr -d ' ')
[ "$rules" = "1" ] || fail "rules dir should contain one entry, got $rules"
if [ -e "$tmp/.cursor/skills/docsdevarea" ] || [ -e "$tmp/.cursor/rules/kit-safety.mdc" ]; then
  fail "guru skill or always-on kit rule was linked"
fi

echo "ok"
```

- [ ] **Step 2: Запустить тест и увидеть падение**

```bash
sh scripts/link-workspace-test.sh
```

Expected: падение, потому что `scripts/link-workspace.sh` ещё нет (`No such file` или `FAIL`).

- [ ] **Step 3: Записать скрипт**

Содержимое `aidocumentation/scripts/link-workspace.sh`:

```sh
#!/bin/sh
set -eu

SCRIPT_DIR=$(CDPATH= cd -- "$(dirname "$0")" && pwd)
KIT=$(CDPATH= cd -- "$SCRIPT_DIR/.." && pwd)
if [ "${1:-}" = "" ]; then
  WINDOW=$(CDPATH= cd -- "$KIT/.." && pwd)
else
  WINDOW=$(CDPATH= cd -- "$1" && pwd)
fi
SITE="$WINDOW/Elitvid_v2"
PLAN="$SITE/.cursor/skills/speckit-plan/SKILL.md"

if [ ! -f "$PLAN" ]; then
  echo "link-workspace: нет $PLAN" >&2
  exit 1
fi

rel() {
  python3 -c 'import os, sys; print(os.path.relpath(sys.argv[1], sys.argv[2]))' "$1" "$2"
}

mkdir -p "$WINDOW/.cursor/skills" "$WINDOW/.cursor/rules"

# Обычный файл в каталоге ссылок — ошибка. Ссылки этого скрипта можно заменить.
clear_links() {
  dir=$1
  [ -d "$dir" ] || return 0
  for entry in "$dir"/*; do
    [ -e "$entry" ] || [ -L "$entry" ] || continue
    if [ -L "$entry" ]; then
      rm "$entry"
    else
      echo "link-workspace: $entry не ссылка, каталог не очищаю" >&2
      exit 1
    fi
  done
}

clear_links "$WINDOW/.cursor/skills"
clear_links "$WINDOW/.cursor/rules"

if [ -e "$WINDOW/.specify" ] && [ ! -L "$WINDOW/.specify" ]; then
  echo "link-workspace: $WINDOW/.specify обычный каталог, ссылку не ставлю" >&2
  exit 1
fi

for skill in "$SITE/.cursor/skills"/speckit-*; do
  [ -d "$skill" ] || continue
  name=$(basename "$skill")
  ln -s "$(rel "$skill" "$WINDOW/.cursor/skills")" "$WINDOW/.cursor/skills/$name"
done

for skill in "$KIT/.cursor/skills"/*; do
  [ -d "$skill" ] || continue
  name=$(basename "$skill")
  ln -s "$(rel "$skill" "$WINDOW/.cursor/skills")" "$WINDOW/.cursor/skills/$name"
done

ln -s "$(rel "$SITE/.cursor/rules/specify-rules.mdc" "$WINDOW/.cursor/rules")" \
  "$WINDOW/.cursor/rules/specify-rules.mdc"
ln -sfn "$(rel "$SITE/.specify" "$WINDOW")" "$WINDOW/.specify"
cp "$KIT/templates/workspace-AGENTS.md" "$WINDOW/AGENTS.md"
```

Сделать оба файла исполняемыми: `chmod +x scripts/link-workspace.sh scripts/link-workspace-test.sh`.

- [ ] **Step 4: Прогнать тест**

```bash
sh scripts/link-workspace-test.sh
```

Expected: последняя строка `ok`, код 0.

- [ ] **Step 5: Связать настоящее окно**

```bash
sh scripts/link-workspace.sh
```

Expected: код 0. Появляются ссылки в `/Users/artemi/projects/Elitvid`.

- [ ] **Step 6: Проверить окно и оба репозитория**

```bash
WINDOW=/Users/artemi/projects/Elitvid
test -L "$WINDOW/.specify"
test -L "$WINDOW/.cursor/rules/specify-rules.mdc"
test -L "$WINDOW/.cursor/skills/speckit-plan"
test -L "$WINDOW/.cursor/skills/elitvid-docs"
test -L "$WINDOW/.cursor/skills/repos-map"
test -f "$WINDOW/.cursor/skills/elitvid-docs/SKILL.md"
test -f "$WINDOW/.cursor/skills/speckit-plan/SKILL.md"
grep -q 'Корень spec-kit' "$WINDOW/AGENTS.md"
test ! -e "$WINDOW/.cursor/rules/kit-safety.mdc"
test ! -e "$WINDOW/.cursor/skills/docsdevarea"
find "$WINDOW/.cursor/rules" -mindepth 1 -maxdepth 1 | wc -l
test ! -d /Users/artemi/projects/Elitvid/Elitvid_v2/.cursor/skills/elitvid-docs
test ! -d /Users/artemi/projects/Elitvid/Elitvid_v2/.cursor/skills/docsdevarea
test ! -d /Users/artemi/projects/Elitvid/Elitvid_v2/specs
test ! -d /Users/artemi/projects/Elitvid/aidocumentation/.cursor/skills/confluence-publish
test ! -f /Users/artemi/projects/Elitvid/aidocumentation/.cursor/mcp.json
```

Expected: `wc -l` печатает `1`. Остальные команды заканчиваются с кодом 0.

`Elitvid_v2/AGENTS.md` совпадает с текстом Task 1. `git -C Elitvid_v2 status --short` не показывает правок `README.md`, `composer.json`, `docker-compose.yml` и `app/`. `git -C aidocumentation status --short` не показывает `.env`.

Не коммитить. `/elitvid-docs` не запускать: тексты `docs/ai/` и `docs/human/` в этот план не входят.
