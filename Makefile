.PHONY: init app db-import

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
