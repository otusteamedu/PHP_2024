DOCKER_COMPOSE = docker compose -f ./_docker/docker-compose.yml

build:
	${DOCKER_COMPOSE} build

start:
	${DOCKER_COMPOSE} start

restart:
	${DOCKER_COMPOSE} restart

stop:
	${DOCKER_COMPOSE} stop

up:
	${DOCKER_COMPOSE} up -d --remove-orphans

down:
	${DOCKER_COMPOSE} down

app_bash:
	${DOCKER_COMPOSE} exec -u www-data php bash

app_nginx:
	${DOCKER_COMPOSE} exec -u www-data nginx bash

php: app_bash
nginx: app_nginx
