setup: env-prepare install db-prepare

request_hanlder-start:
	php ./jobs/apiRequestProcessor.php

install:
	composer install

up:
	docker compose up

down:
	docker compose down --remove-orphans

env-prepare:
	cp -n .env.example .env || true

db-create:
	touch db/database.sqlite3

db-migrate:
	vendor/bin/phinx migrate -e development

db-prepare: db-create db-migrate