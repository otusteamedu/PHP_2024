# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

## Quickstart

1. [Install git](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git)
2. [Install docker](https://docs.docker.com/install/)
3. [Install docker-compose](https://docs.docker.com/compose/install/)
4. [Install make](https://wiki.ubuntu.com/ubuntu-make)

```
cp .env.example .env
#Add mapping ports for redis, musql, memcached
```

###Run via console

```
docker-compose up -d --build
docker-compose exec app bash
composer install
```

###Run via make

```
make start-otus
```

##Usage 

docker-compose run app php frontend/web/index.php 'valera@gmail.com,valera@gmail.con,valera @gmail.com'

or

docker-compose exec server bash
php frontend/web/index.php index.php 'valera@gmail.com,valera@gmail.con,valera @gmail.com'