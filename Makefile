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
