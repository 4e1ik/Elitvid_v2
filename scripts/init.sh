#!/usr/bin/env bash
# Поднимает локальное окружение: контейнеры, elitvid_db, импорт дампа, Laravel.

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"

DUMP_NAME="cr48940_elitvid.sql"
ORDERED_NAME="cr48940_elitvid_ordered.sql"
STORAGE_DIR="storage/app/public"
FILES_DIR="public/elitvid_assets/newDesign/newDesign/files"
DB_CONTAINER="elitvid_db"
PHP_CONTAINER="php_elitvid"
DB_NAME="elitvid_db"
DB_USER="root"
DB_PASSWORD="root"

dir_has_file_except() {
  local dir="$1"
  local except="$2"
  local file base
  [[ -d "$dir" ]] || return 1
  while IFS= read -r -d '' file; do
    base="$(basename "$file")"
    if [[ -n "$except" && "$base" == "$except" ]]; then
      continue
    fi
    return 0
  done < <(find "$dir" -type f -print0)
  return 1
}

files_ready() {
  [[ -f "$ROOT/$DUMP_NAME" ]] \
    && dir_has_file_except "$ROOT/$STORAGE_DIR" ".gitignore" \
    && dir_has_file_except "$ROOT/$FILES_DIR" ""
}

missing_items() {
  local missing=0
  if [[ ! -f "$ROOT/$DUMP_NAME" ]]; then
    echo "дамп $DUMP_NAME в корне проекта"
    missing=1
  fi
  if ! dir_has_file_except "$ROOT/$STORAGE_DIR" ".gitignore"; then
    echo "файлы в $STORAGE_DIR, кроме .gitignore"
    missing=1
  fi
  if ! dir_has_file_except "$ROOT/$FILES_DIR" ""; then
    echo "файлы в $FILES_DIR"
    missing=1
  fi
  return "$missing"
}

decide_db_action() {
  local has_dump="$1"
  local tables="$2"
  local choice="$3"
  if [[ "$has_dump" == "0" ]]; then
    if [[ "$tables" == "0" ]]; then
      printf '%s\n' "empty"
    else
      printf '%s\n' "keep"
    fi
    return 0
  fi
  if [[ "$tables" == "0" ]]; then
    printf '%s\n' "import"
    return 0
  fi
  if [[ "$choice" == "reimport" ]]; then
    printf '%s\n' "reimport"
  else
    printf '%s\n' "keep"
  fi
}

should_migrate() {
  case "$1" in
    keep|import|reimport) return 0 ;;
    *) return 1 ;;
  esac
}

build_ordered_sql() {
  {
    printf '%s\n' "SET FOREIGN_KEY_CHECKS=0;" "SET NAMES utf8mb4;"
    cat "$ROOT/$DUMP_NAME"
    printf '\n%s\n' "SET FOREIGN_KEY_CHECKS=1;"
  } > "$ROOT/$ORDERED_NAME"
}

app_key_present() {
  local line value
  [[ -f "$ROOT/.env" ]] || return 1
  line="$(grep -E '^APP_KEY=' "$ROOT/.env" | head -n 1 || true)"
  [[ -n "$line" ]] || return 1
  value="${line#APP_KEY=}"
  if [[ "$value" == \"*\" ]]; then
    value="${value:1:$((${#value} - 2))}"
  fi
  [[ -n "$value" ]]
}

has_tty() {
  [[ -r /dev/tty && -w /dev/tty ]]
}

read_choice() {
  local prompt="$1"
  local answer
  while true; do
    printf '%s ' "$prompt" >/dev/tty
    if ! IFS= read -r answer </dev/tty; then
      echo "Терминал закрыт. Остановка." >&2
      return 1
    fi
    case "$answer" in
      1|2)
        printf '%s\n' "$answer"
        return 0
        ;;
      *)
        printf 'Введите 1 или 2.\n' >/dev/tty
        ;;
    esac
  done
}

wait_for_mysql() {
  local i
  for i in $(seq 1 30); do
    if docker exec "$DB_CONTAINER" mysqladmin ping -u"$DB_USER" -p"$DB_PASSWORD" --silent >/dev/null 2>&1; then
      return 0
    fi
    sleep 2
  done
  echo "MariaDB не приняла подключение за 60 секунд." >&2
  return 1
}

table_count() {
  local count
  count="$(docker exec "$DB_CONTAINER" mysql -u"$DB_USER" -p"$DB_PASSWORD" -N -e \
    "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='${DB_NAME}'" \
    | tr -d '[:space:]')"
  if [[ -z "$count" ]]; then
    printf '%s\n' "0"
    return 0
  fi
  printf '%s\n' "$count"
}

mysql_exec() {
  docker exec -i "$DB_CONTAINER" mysql -u"$DB_USER" -p"$DB_PASSWORD" "$@"
}

import_ordered_sql() {
  cat "$ROOT/$ORDERED_NAME" | docker exec -i "$DB_CONTAINER" mysql -u"$DB_USER" -p"$DB_PASSWORD" "$DB_NAME"
}

apply_db_action() {
  local action="$1"
  local create_sql="CREATE DATABASE IF NOT EXISTS ${DB_NAME} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; ALTER DATABASE ${DB_NAME} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
  case "$action" in
    reimport)
      mysql_exec -e "DROP DATABASE IF EXISTS ${DB_NAME}; CREATE DATABASE ${DB_NAME} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
      build_ordered_sql
      import_ordered_sql
      ;;
    import)
      mysql_exec -e "$create_sql"
      build_ordered_sql
      import_ordered_sql
      ;;
    empty|keep)
      mysql_exec -e "$create_sql"
      ;;
    *)
      echo "Неизвестное действие с базой: $action" >&2
      return 1
      ;;
  esac
}

prepare_app() {
  local action="$1"
  docker exec "$PHP_CONTAINER" composer install --no-interaction
  if [[ ! -f "$ROOT/.env" ]]; then
    echo "Файл .env не найден. Скопируйте его из .env.example и заполните." >&2
    return 1
  fi
  if app_key_present; then
    echo "APP_KEY уже задан."
  else
    docker exec "$PHP_CONTAINER" php artisan key:generate
  fi
  if [[ -L "$ROOT/public/storage" || -e "$ROOT/public/storage" ]]; then
    echo "Симлинк public/storage уже есть."
  else
    docker exec "$PHP_CONTAINER" php artisan storage:link
  fi
  if should_migrate "$action"; then
    docker exec "$PHP_CONTAINER" php artisan migrate --force
  else
    echo "База пустая, php artisan migrate пропущен."
  fi
}

main() {
  set -euo pipefail
  cd "$ROOT"
  docker compose up -d --build
  wait_for_mysql

  if ! files_ready; then
    echo "Не хватает:"
    missing_items || true
    echo
    echo "1) Продолжить с тем, что уже лежит в проекте"
    echo "2) Остановиться"
    if ! has_tty; then
      echo "Нет терминала для вопроса. Остановка. База не изменена."
      exit 1
    fi
    local file_choice
    file_choice="$(read_choice "Выбор [1/2]:")"
    if [[ "$file_choice" != "1" ]]; then
      echo "Остановка. База не изменена."
      exit 1
    fi
  fi

  local tables has_dump reimport_choice action
  tables="$(table_count)"
  has_dump=0
  if [[ -f "$ROOT/$DUMP_NAME" ]]; then
    has_dump=1
  fi
  reimport_choice="keep"
  if [[ "$has_dump" -eq 1 && "$tables" -gt 0 ]]; then
    echo "В ${DB_NAME} уже есть таблицы (${tables})."
    echo "1) Оставить данные"
    echo "2) Удалить базу и импортировать дамп заново"
    if ! has_tty; then
      echo "Нет терминала. Оставляю существующие данные."
    else
      local data_choice
      data_choice="$(read_choice "Выбор [1/2]:")"
      if [[ "$data_choice" == "2" ]]; then
        reimport_choice="reimport"
      fi
    fi
  fi

  action="$(decide_db_action "$has_dump" "$tables" "$reimport_choice")"
  echo "Действие с базой: ${action}"
  apply_db_action "$action"
  prepare_app "$action"
  echo "Готово. Сайт: http://localhost:8080"
}

if [[ "${BASH_SOURCE[0]}" == "$0" ]]; then
  main "$@"
fi
