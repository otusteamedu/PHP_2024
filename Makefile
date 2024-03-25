start:
	docker-compose -f ./docker-compose.yml --env-file .env exec app composer config --global discard-changes true
	docker-compose -f ./docker-compose.yml --env-file .env exec app composer install --no-interaction --prefer-dist --no-progress --no-suggest
	docker-compose -f ./docker-compose.yml --env-file .env exec app php frontend/web/index.php init
	docker-compose -f ./docker-compose.yml --env-file .env exec app php frontend/web/index.php test
docker-up:
	docker-compose up -d --build
docker-down:
	docker-compose down --remove-orphans
docker-build:
	docker-compose build

start-otus: docker-up start
stop-otus: docker-down
