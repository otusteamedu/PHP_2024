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
client:
	docker exec -ti app-client php app.php --mode client
server:
	docker exec -ti app-server php app.php --mode server