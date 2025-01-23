.PHONY: up down exec shell

include .env

up:
	docker-compose up -d --build

down:
	docker-compose down

exec:
	docker exec -it ${PROJECT_PREFIX}-php-fpm $(ARGS)

shell:
	make exec ARGS=bash

init:
	make exec ARGS="composer install && composer db:up"

start_consume:
	make exec ARGS="php bin/console rabbitmq:consumer -m 5 email.submitted"
