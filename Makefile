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

doctrine-validate:
	make exec ARGS='php bin/console doctrine:schema:validate'

doctrine-diff:
	make exec ARGS='php bin/console doctrine:migrations:diff'

doctrine-migrate:
	make exec ARGS='php bin/console doctrine:migrations:migrate'
