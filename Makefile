start:
	docker-compose up -d

stop:
	docker-compose stop

on:
	docker-compose build
	docker-compose up -d

off:
	docker-compose down

restart:
	docker-compose down
	docker-compose build
	docker-compose up -d

exec:
	docker exec -it php-cli bash

create-index:
	docker exec -it php-cli ./app.php create-index

search:
	docker exec -it php-cli ./app.php search --title="Терминатор" --category="Детектив" --priceFrom=2900 --priceTo=3900 --shop="Мира" --stock=15