start:
	docker-compose -f ./docker-compose.yml --env-file .env exec server composer config --global discard-changes true
	docker-compose -f ./docker-compose.yml --env-file .env exec server composer install --no-interaction --prefer-dist --no-progress --no-suggest

docker-up:
	docker-compose up -d --build
docker-down:
	docker-compose down --remove-orphans
docker-build:
	docker-compose build

start-otus: docker-up start
stop-otus: docker-down
