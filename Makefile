setup: env-prepare install

start-frontend:
	php -S 0.0.0.0:8080 -t public

start-console:
	php ./console/queue.php

install:
	composer install

up:
	docker compose up

down:
	docker compose down --remove-orphans

env-prepare:
	cp -n .env.example .env || true