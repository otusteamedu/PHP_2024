# Деплой

1) В директориях .deployment/docker и корне проекта скопировать файл `.env.dist` как `.env`.
2) Заполнить поля в `.env` файле. Для примера можно взять данные ниже:
- docker
```dotenv
COMPOSE_PROJECT_NAME=example

###> php-fpm ###
PUID=1000
PGID=1000
INSTALL_XDEBUG=true
###< php-fpm ###

###> nginx ###
PHP_UPSTREAM_CONTAINER=php-fpm
PHP_UPSTREAM_PORT=9000
NGINX_HOST_HTTP_PORT=8888
###< nginx ###

###> postgres ###
POSTGRES_DB_HOST=postgres
POSTGRES_DB_NAME=homework
POSTGRES_PORT=5432
POSTGRES_USER=apps
POSTGRES_PASSWORD=apps
###< postgres ###
```

- проект
```dotenv
###> symfony/framework-bundle ###
APP_ENV=dev
APP_SECRET=127fd5cfb3a534e2516876f14975e122
###< symfony/framework-bundle ###

###> doctrine/doctrine-bundle ###
DATABASE_URL="postgresql://apps:apps@postgres:5432/homework?serverVersion=16&charset=utf8"
###< doctrine/doctrine-bundle ###
```

3) Ввести команды (при необходимости можно изменить `docker-compose` или `docker compose` в Makefile):

```bash
make dc_up_build
```

4) Установите зависимости после успешного запуска проекта:

```bash
make com_i
```
