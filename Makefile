include .env

init: docker-down-clear docker-pull docker-build docker-up init-db
up: docker-up
down: docker-down
restart: down up

docker-up:
	docker compose up -d

docker-down:
	docker compose down --remove-orphans

docker-down-clear:
	docker compose down -v --remove-orphans

docker-pull:
	docker compose pull

docker-build:
	docker compose build

check-postgres:
	docker ps | grep ${DB_CONTAINER_NAME}

db-wait:
	until docker-compose exec -T postgres pg_isready --timeout=0 --dbname=$(POSTGRES_DB) ; do sleep 1 ; done

db-create-tables:
	cat sql/init/tables.sql | docker exec -i ${DB_CONTAINER_NAME} psql -U ${DB_USER} -d ${DB_NAME}

db-init-triggers:
	cat sql/init/triggers.sql | docker exec -i ${DB_CONTAINER_NAME} psql -U ${DB_USER} -d ${DB_NAME}

db-insert-data:
	cat sql/data.sql | docker exec -i ${DB_CONTAINER_NAME} psql -U ${DB_USER} -d ${DB_NAME}

db-get-film:
	cat sql/most_profitable_film.sql | docker exec -i ${DB_CONTAINER_NAME} psql -U ${DB_USER} -d ${DB_NAME}

init-db: check-postgres db-wait db-create-tables db-init-triggers db-insert-data db-get-film
