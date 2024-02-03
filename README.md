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

###web

Add this lines to your hosts file

```
127.0.0.1 mysite.local
```
