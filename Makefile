up:
	docker-compose up -d --build

down:
	docker-compose down

shell:
	docker exec -it otus-shop-php-cli bash

# Инициализация (создание индекса с правильным маппингом и заполнение его данными)
init:
	docker exec -it otus-shop-php-cli php index.php index:delete otus-shop \
		&& docker exec -it otus-shop-php-cli php index.php index:create otus-shop /data/var/import/schema.json \
		&& docker exec -it otus-shop-php-cli php index.php index:seed otus-shop /data/var/import/books.json

# Поиск по заголовку
search-1:
	docker exec -it otus-shop-php-cli php index.php shop:search-book --title="Джон"

# Поиск по заголовку с ошибкой
search-2:
	docker exec -it otus-shop-php-cli php index.php shop:search-book --title="кравать"

# Поиск по заголовку для проверки морфологии
search-3:
	docker exec -it otus-shop-php-cli php index.php shop:search-book --title="похождение"

# Поиск по заголовку, категории и максимальной цене
search-4:
	docker exec -it otus-shop-php-cli php index.php shop:search-book --title="похождение" --category="Детектив" --price_max=200

# Поиск по максимальной цене и минимальной цене
search-5:
	docker exec -it otus-shop-php-cli php index.php shop:search-book --price_min=100 --price_max=200

# Поиск по категории, мин. цене и по остаткам
search-6:
	docker exec -it otus-shop-php-cli php index.php shop:search-book --category="Исторический роман" --price_max=2000 --in_stock=1

# Все книги без фильтрации
search-7:
	docker exec -it otus-shop-php-cli php index.php shop:search-book --title="Джон"
