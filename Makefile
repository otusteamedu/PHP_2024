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