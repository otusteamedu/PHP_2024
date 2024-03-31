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
docker compose exec app composer install
```

5) Пример запроса на поиск:
- indexName - имя индекса, по которому будет осуществлен поиск;
- title - наименование книги;
- category - категория книги;
- shopName - имя магазина;
- gtPrice - нижняя граница цены;
- ltePrice - верхняя граница цены.

Можно передать любое количество опций в команду.
При первом запросе результат может быть пустым, 
т.к. сначала будет запущено создание индекса и загрузка в него дынных.

```bash
php app.php --indexName 'otus-shop' --title 'Жутки' --category 'Искусство' --gtPrice 7000 --ltePrice 9000 --shopName 'Мира'
```
