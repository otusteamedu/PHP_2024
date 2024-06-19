# Деплой

1) Скопировать файл `.env.dist` как `.env`.
2) Заполнить поля в `.env` файле. Для примера можно взять данные ниже:

```dotenv
COMPOSE_PROJECT_NAME=homework30

###> php-fpm ###
PUID=1001
PGID=1001
INSTALL_XDEBUG=true
###< php-fpm ###

###> nginx ###
PHP_UPSTREAM_CONTAINER=php-fpm
PHP_UPSTREAM_PORT=9000
NGINX_HOST_HTTP_PORT=8888
###< nginx ###

###> rabbit-mq ###
RABBIT_HOST=rabbitmq
RABBIT_PORT=5672
RABBIT_MANAGEMENT_PORT=15672
RABBIT_USER=guest
RABBIT_PASSWORD=guest
###< rabbit-mq ###

###> tamplates ###
HTML_TEMPLATES_PATH=${PWD}/../templates/
###< tamplates ###
```

3) Ввести команды (вводить `docker-compose` или `docker compose` в зависимости от версии):

```bash
docker compose up -d --build
```

4) Установите зависимости после успешного запуска проекта:

```bash
docker compose exec php-fpm composer install
```

5) Пример запроса на поиск:

