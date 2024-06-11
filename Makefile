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
	docker exec -it php-fpm bash