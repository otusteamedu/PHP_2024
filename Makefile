include .env
export $(shell sed 's/=.*//' .env)

up:
	docker-compose up -d

down:
	docker-compose down

p1 bash:
	docker exec -it ${CONTAINER_NAME_PHP_FPM_1} /bin/bash

p2 bash:
	docker exec -it ${CONTAINER_NAME_PHP_FPM_2} /bin/bash

build:
	docker-compose build
