##################
# Variables
##################

DOCKER_COMPOSE = docker compose -f ./.deployment/docker/docker-compose.yml --env-file ./.deployment/docker/.env
DOCKER_EXEC_PHP = docker exec -it php-fpm

##################
# Docker compose
##################

dc_build:
	${DOCKER_COMPOSE} build

dc_start:
	${DOCKER_COMPOSE} start

dc_stop:
	${DOCKER_COMPOSE} stop

dc_up:
	${DOCKER_COMPOSE} up -d

dc_up_build:
	${DOCKER_COMPOSE} up -d --build

dc_ps:
	${DOCKER_COMPOSE} ps

dc_logs:
	${DOCKER_COMPOSE} logs -f

dc_down:
	${DOCKER_COMPOSE} down -v --rmi=all --remove-orphans

dc_restart:
	make dc_stop dc_start


##################
# App
##################

app_bash:
	${DOCKER_EXEC_PHP} bash
com_i:
	${DOCKER_EXEC_PHP} composer install
com_r:
	${DOCKER_EXEC_PHP} composer require
test:
	${DOCKER_EXEC_PHP} php bin/phpunit
cache:
	${DOCKER_EXEC_PHP} php bin/console cache:clear
m_run:
	${DOCKER_EXEC_PHP} php bin/console doctrine:migration:migrate
fx_load:
	${DOCKER_EXEC_PHP} php bin/console doctrine:fixtures:load
init:
	make com_i m_run fx_load
