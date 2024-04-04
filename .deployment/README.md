# Деплой

1) Скопировать файл `.env.dist` как `.env`.
2) Заполнить поля в `.env` файле. Для примера можно взять данные ниже:

```dotenv
COMPOSE_PROJECT_NAME=homework15

###> php-fpm ###
PUID=1001
PGID=1001
INSTALL_XDEBUG=true
###< php-fpm ###

###> redis ###
REDIS_HOST=redis
REDIS_PORT=6379
###< redis ###

```

3) Ввести команды (вводить `docker-compose` или `docker compose` в зависимости от версии):

```bash
docker compose up -d --build
```

4) Установите зависимости после успешного запуска проекта:

```bash
docker compose exec php-fpm composer install
```

5) Примеры запросов:
- добавить новое событие:
```bash
php app.php --action addEvent --priority 4000 --name randomEvent --conditions "[param1=1 param2=4]"
```

- очистить хранилище событий:
```bash
php app.php --action clearEvents
```
