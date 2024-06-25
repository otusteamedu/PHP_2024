# Деплой

1) В директориях .deployment/docker и корне проекта скопировать файл `.env.dist` как `.env`.
2) Заполнить поля в `.env` файле. Для примера можно взять данные ниже:
- docker
```dotenv
COMPOSE_PROJECT_NAME=homework21

###> php-fpm ###
PUID=1000
PGID=1000
INSTALL_XDEBUG=true
###< php-fpm ###

###> nginx ###
PHP_UPSTREAM_CONTAINER=php-fpm
PHP_UPSTREAM_PORT=9000
NGINX_HOST_HTTP_PORT=80
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
APP_SECRET=vcdcfshjmnbgvfdcsf
###< symfony/framework-bundle ###

###> doctrine/doctrine-bundle ###
DATABASE_URL="postgresql://apps:apps@postgres:5432/homework?serverVersion=16&charset=utf8"
###< doctrine/doctrine-bundle ###

###> php-webdriver/webdriver (selenium) ###
SELENIUM_GRID_URL=http://selenium-hub:4444/wd/hub
###< php-webdriver/webdriver (selenium) ###

###> reports ###
REPORT_FILE_PATH=/public/reports
NEWS_REPORT_FILE_PREFIX=news_report_
REPORT_URL=http://localhost:8888/reports
###< reports ###
```

3) Ввести команды (при необходимости можно изменить `docker-compose` или `docker compose` в Makefile):

```bash
make dc_up_build
```

4) Установите зависимости после успешного запуска проекта:

```bash
make com_i
```

5) Далее для проверки можно использовать следующие запросы
- создание новости:
```shell
curl --location 'localhost:80/news/create' \
--header 'Content-Type: application/json' \
--data '{
    "url": "https://dzen.ru/news/story/8f68bb32-2f4b-50da-bc72-0ae765f1f5a3?lang=ru&rubric=index&fan=1&t=1714323549&tt=true&persistent_id=2775185036&cl4url=936bd4e82cd07c503332e93f68393629&story=25d21ba7-8000-5a1f-af6f-6bd215d8cfba"
}'
```

- получение списка новостей:
```shell
curl --location 'localhost:80/news'
```

- создание отчета:
```shell
curl --location --request POST 'localhost:80/report/create'
```
