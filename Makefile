.DEFAULT_GOAL := recreate

recreate:
	docker-compose down -v --remove-orphans && docker-compose up -d && docker-compose ps
build:
	docker-compose build
upd:
	docker-compose up -d
down:
	docker-compose down
stop:
	docker-compose stop
start:
	docker-compose start
ps:
	docker-compose ps
cinit:
	docker-compose run --rm app composer init
cinstall:
	docker-compose run --rm app composer install
run:
	docker-compose run --rm app php app.php --query=Рыцорь --gte=1000 --lte=1234 --category="Исторический роман" --shop=Мира

cmd-hlp:
	docker-compose run --rm app ./bin/console app:search-book --help

bash:
	docker-compose run --rm app /bin/bash

cmd:
	docker-compose run --rm app ./bin/console app:search-book --query=Рыцорь --gte=1000 --lte=1234 --category="Исторический роман" --shop=Мира
