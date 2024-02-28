include .env

init: docker-down-clear docker-pull docker-build docker-up app-init
up: docker-up
down: docker-down
restart: down up

docker-up:
	docker compose up -d

docker-down:
	docker compose down --remove-orphans

docker-down-clear:
	docker compose down -v --remove-orphans

docker-pull:
	docker compose pull

docker-build:
	docker compose build

app-init: app-composer-install app-chat-start

app-composer-install:
	docker compose run --rm ${SERVER_NAME} composer install

app-chat-start: app-server-start app-client-start

app-server-start:
	docker compose run -d --rm ${SERVER_NAME} php app.php server

app-client-start:
	docker compose run --rm ${CLIENT_NAME} php app.php client
