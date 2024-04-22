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

exec-redis-cli:
	docker exec -it redis redis-cli

get:
	docker exec -it php-cli ./app.php get --condition="param1=1" --condition="param2=2"