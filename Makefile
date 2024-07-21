init: env docker-build docker-up init-all docker-down docker-up
up: docker-up
down: docker-down
restart: down up
rebuild: down docker-build up

env:
	cp .env.test .env

init-all:
	sleep 10
	docker compose exec app composer install --no-interaction --prefer-dist --no-progress --no-suggest
	docker compose exec app php console/yii migrate --interactive=0

docker-up:
	docker compose up -d

docker-down:
	docker compose down --remove-orphans

docker-down-clear:
	docker compose down -v --remove-orphans

docker-build:
	docker compose build
	
composer:
	docker compose exec app composer install --no-interaction --prefer-dist --no-progress --no-suggest

migrate:
	docker compose exec app php console/yii migrate --interactive=0

bash:
	docker compose exec app bash

sw:
	docker compose exec app composer run generate-swagger
