up:
	docker-compose up -d

down:
	docker-compose down

shell:
	docker exec -it otus-shop-php-cli bash

# Инициализация (создание индекса с правильным маппингом и заполнение его данными)
init:
	docker exec -it otus-shop-php-cli php index.php init /data/var/import/books.json

# Поиск по заголовку
search-1:
	docker exec -it otus-shop-php-cli php index.php search --title="Джон"

# Поиск по заголовку с ошибкой
search-2:
	docker exec -it otus-shop-php-cli php index.php search --title="кравать"

# Поиск по заголовку для проверки морфологии
search-3:
	docker exec -it otus-shop-php-cli php index.php search --title="ночь"

# Поиск по заголовку, категории и максимальной цене
search-4:
	docker exec -it otus-shop-php-cli php index.php search --title="кравать" --category="Детектив" --price_max=133

# Поиск по максимальной цене и минимальной цене
search-5:
	docker exec -it otus-shop-php-cli php index.php search --price_min=100 --price_max=200

# Поиск по максимальной цене и минимальной цене
search-5:
	docker exec -it otus-shop-php-cli php index.php search --category="Исторический роман" --price_max=2000 --in_stock=0
