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

- вернуть все записи:
```bash
php app.php --action getAllHalls
```

- вернуть зал по id
```bash
php app.php --action getHallById --id 1
```

- обновить запись по id
```bash
app.php --action updateHall --id 7 --name "Тестовый кинозал 7" --capacity 260 --rowsCount 26
```

- удаление записи по id
```bash
php app.php --action deleteHall --id 7
```
