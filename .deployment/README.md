# Деплой

1) Скопировать файл `.env.dist` как `.env`.

```dotenv
COMPOSE_PROJECT_NAME=homework30

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

###> rabbit-mq ###
RABBIT_HOST=rabbitmq
RABBIT_PORT=5672
RABBIT_MANAGEMENT_PORT=15672
RABBIT_USER=guest
RABBIT_PASSWORD=guest
###< rabbit-mq ###

###> tamplates ###
HTML_TEMPLATES_PATH=${PWD}/templates/
###< tamplates ###
```

2) Ввести команды (вводить `docker-compose` или `docker compose` в зависимости от версии):

```bash
docker compose up -d --build
```

3) Примеры запросов:

- получение формы для запроса банковской выгрузки:
```shell
curl --location 'localhost:8888/bank/statement'
```

- генерация банковской выгрузки:
```shell
curl --location --request POST 'localhost:8888/bank/statement/generate' \
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
- переходим на страницу формы в браузере `localhost:8888/bank/statement`;
- отправляем форму для выгрузки (все поля обязательны для заполнения);
- в контейнера `app-console` смотрим вывоз консоли (там должна появиться информация об обработке).
