.PHONY: init app db-import test-db

# Контейнеры, база elitvid_db, импорт дампа и подготовка Laravel
init:
	bash scripts/init.sh

# Подключение к контейнеру с PHP-FPM
app:
	docker exec -it php_elitvid bash

# Импорт SQL файла в базу данных (использует cr48940_elitvid_ordered.sql)
db-import:
	@if [ ! -f cr48940_elitvid_ordered.sql ]; then \
		echo "Файл cr48940_elitvid_ordered.sql не найден. Создайте его из cr48940_elitvid.sql"; \
		exit 1; \
	fi
	cat cr48940_elitvid_ordered.sql | docker exec -i elitvid_db mysql -uroot -proot elitvid_db
	@echo "Импорт завершен успешно!"

# Пустая база elitvid_testing для phpunit (phpunit.xml направляет тесты туда)
test-db:
	docker exec elitvid_db mysql -uroot -proot -e "CREATE DATABASE IF NOT EXISTS elitvid_testing CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
