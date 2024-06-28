# Деплой

1) Скопировать файл `.env.dist` как `.env`.

```dotenv
COMPOSE_PROJECT_NAME=homework31

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

###> rabbit-mq ###
RABBIT_HOST=rabbitmq
RABBIT_PORT=5672
RABBIT_MANAGEMENT_PORT=15672
RABBIT_USER=guest
RABBIT_PASSWORD=guest
###< rabbit-mq ###
```

2) Ввести команды (вводить `docker-compose` или `docker compose` в зависимости от версии):

```bash
docker compose up -d --build
```

3) Примеры запросов:

- запрос проверки состояния банковской выгрузки:
```shell
curl --location --request GET 'localhost:8888/bank/statement/1'
```

- генерация банковской выгрузки:
```shell
curl --location --request POST 'localhost:8888/bank/statement' \
--form 'clientName="CLIENT"' \
--form 'accountNumber="777"' \
--form 'startDate="2021-09-07"' \
--form 'endDate="2023-05-20"'
```

- запуск консьюмера:

```shell
php console/command.php Alogachev\\Homework\\Infrastructure\\Command\\GenerateBankStatementCommand
```

4) Как проверить:
- деплоим приложение
- отправить запрос на генерацию выгрузки;
- отправить запрос на проверку состояния выгрузки;
- в контейнера `app-console` смотрим вывод консоли (там должна появиться информация об обработке).
