init: docker-down docker-build docker-up

docker-down:
	docker compose down --remove-orphans

docker-build:
	docker compose build

docker-up:
	docker compose up -d

composer-install:
	docker-compose run --rm php-fpm composer install
