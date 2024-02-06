include .env
export

init: docker-down-clear docker-pull docker-build docker-up app-init
up: docker-up
down: docker-down
restart: down up

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build

app-init: app-composer-install app-wait-db

app-composer-install:
	docker-compose run --rm php-cli composer install

app-wait-db:
	until docker-compose exec -T postgres pg_isready --timeout=0 --dbname=$(POSTGRES_DB) ; do sleep 1 ; done
