#!/usr/bin/env bash
# Проверяет решения scripts/init.sh без Docker.

set -u

ROOT_PROJECT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
# shellcheck source=init.sh
source "$ROOT_PROJECT/scripts/init.sh"

fail=0

ok() {
  echo "OK $1"
}

bad() {
  echo "FAIL $1: got [$2] expected [$3]"
  fail=$((fail + 1))
}

assert_eq() {
  if [[ "$1" == "$2" ]]; then
    ok "$3"
  else
    bad "$3" "$1" "$2"
  fi
}

assert_migrate() {
  if should_migrate "$1"; then
    ok "migrate $1"
  else
    bad "migrate $1" "no" "yes"
  fi
}

assert_no_migrate() {
  if should_migrate "$1"; then
    bad "migrate $1" "yes" "no"
  else
    ok "migrate $1 skipped"
  fi
}

assert_eq "$(decide_db_action 0 0 keep)" "empty" "no dump, no tables"
assert_eq "$(decide_db_action 0 4 keep)" "keep" "no dump, tables exist"
assert_eq "$(decide_db_action 1 0 keep)" "import" "dump, no tables"
assert_eq "$(decide_db_action 1 4 keep)" "keep" "dump, keep existing"
assert_eq "$(decide_db_action 1 4 reimport)" "reimport" "dump, reimport"

assert_no_migrate empty
assert_migrate keep
assert_migrate import
assert_migrate reimport

tmp="$(mktemp -d)"
ROOT="$tmp"
mkdir -p "$ROOT/$STORAGE_DIR" "$ROOT"
printf '*\n!.gitignore\n' > "$ROOT/$STORAGE_DIR/.gitignore"

text="$(missing_items || true)"
printf '%s\n' "$text" | grep -q "дамп" || bad "missing dump listed" "$text" "дамп"
printf '%s\n' "$text" | grep -q "$STORAGE_DIR" || bad "missing storage listed" "$text" "$STORAGE_DIR"
printf '%s\n' "$text" | grep -q "$FILES_DIR" || bad "missing files listed" "$text" "$FILES_DIR"
if files_ready; then
  bad "files_ready empty project" "yes" "no"
else
  ok "files_ready empty project"
fi

printf 'SELECT 1' > "$ROOT/$DUMP_NAME"
mkdir -p "$ROOT/$STORAGE_DIR/images" "$ROOT/$FILES_DIR"
printf 'img' > "$ROOT/$STORAGE_DIR/images/a.webp"
printf 'pdf' > "$ROOT/$FILES_DIR/a.pdf"
if files_ready; then
  ok "files_ready complete project"
else
  bad "files_ready complete project" "no" "yes"
fi
text="$(missing_items || true)"
assert_eq "$text" "" "nothing missing"

build_ordered_sql
ordered="$(cat "$ROOT/$ORDERED_NAME")"
expected="$(printf '%s\n' "SET FOREIGN_KEY_CHECKS=0;" "SET NAMES utf8mb4;" "SELECT 1" "SET FOREIGN_KEY_CHECKS=1;")"
assert_eq "$ordered" "$expected" "ordered sql without trailing newline in dump"

printf 'APP_KEY=\n' > "$ROOT/.env"
if app_key_present; then
  bad "empty APP_KEY" "present" "absent"
else
  ok "empty APP_KEY"
fi
printf 'APP_KEY=base64:abc\n' > "$ROOT/.env"
if app_key_present; then
  ok "plain APP_KEY"
else
  bad "plain APP_KEY" "absent" "present"
fi
printf 'APP_KEY="base64:abc"\n' > "$ROOT/.env"
if app_key_present; then
  ok "quoted APP_KEY"
else
  bad "quoted APP_KEY" "absent" "present"
fi
rm -f "$ROOT/.env"
if app_key_present; then
  bad "missing .env" "present" "absent"
else
  ok "missing .env"
fi

rm -rf "$tmp"
ROOT="$ROOT_PROJECT"

if [[ "$fail" -eq 0 ]]; then
  echo "All checks passed"
  exit 0
fi
echo "$fail checks failed"
exit 1
