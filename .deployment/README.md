# Деплой

1) Скопировать файл `.env.dist` как `.env`.
2) Заполнить поля в `.env` файле. Для примера можно взять данные ниже:

```dotenv
COMPOSE_PROJECT_NAME=homework

###> php-fpm ###
PUID=1001
PGID=1001
INSTALL_XDEBUG=true
###< php-fpm ###

###> app ###
CONFIG_PATH=${PWD}/../config/config.ini
###< app ###
```

3) Ввести команды (вводить `docker-compose` или `docker compose` в зависимости от версии):

```bash
docker compose up -d --build
```

4) Установите зависимости после успешного запуска проекта:

```bash
docker compose exec server composer install
docker compose exec client composer install
```
