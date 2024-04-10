# Деплой

1) Скопировать файл `.env.dist` как `.env`.
2) Заполнить поля в `.env` файле. Для примера можно взять данные ниже:

```dotenv
COMPOSE_PROJECT_NAME=homework17

###> php-fpm ###
PUID=1001
PGID=1001
INSTALL_XDEBUG=true
###< php-fpm ###

###> postgres ###
POSTGRES_DB_HOST=postgre
POSTGRES_DB_NAME=homework
POSTGRES_PORT=5432
POSTGRES_USER=apps
POSTGRES_PASSWORD=apps
###< postgres ###
```

3) Ввести команды (вводить `docker-compose` или `docker compose` в зависимости от версии):

```bash
docker compose up -d --build
```

4) Установите зависимости после успешного запуска проекта:

```bash
docker compose exec app composer install
```

5) Примеры запросов:
- добавить новый кинозал:
```bash
php app.php --action createHall --name "Тестовый кинозал 2" --capacity 250 --rowsCount 25
```

- очистить хранилище событий:
```bash
php app.php --action clearEvents
```

- поиск наиболее подходящего события
```bash
php app.php --action findTheMostSuitableEvent  --conditions "[param1=1 param2=4]"
```
