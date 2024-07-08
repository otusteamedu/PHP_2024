up:
	docker compose up

build:
	docker compose build

re-build: build up

lint:
	composer exec --verbose ~/.config/composer/vendor/bin/phpcs -- --standard=PSR12 app

db:
	docker run --rm -e POSTGRES_DB=cinema -e POSTGRES_USER=pozys -e POSTGRES_PASSWORD=pozys -p 5432:5432 -v \
/${PWD}/pgdata:/var/lib/postgresql/data --name postgresql postgres

docker-start:
	sudo service docker start

redis-start:
	docker run --restart=always --name redis --hostname redis -p 6379:6379 -d redis

redis-connect:
	docker exec -it redis redis-cli

redisinsight-run:
	docker run -d --name redisinsight -p 5540:5540 redis/redisinsight:latest