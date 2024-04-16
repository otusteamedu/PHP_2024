# О проекте
## Деплой

1) Скопировать файл `.env.dist` как `.env`.
2) Заполнить поля в `.env` файле. Для примера можно взять данные ниже:

```dotenv
COMPOSE_PROJECT_NAME=homework8

###> php-fpm ###
PUID=1000
PGID=1000
INSTALL_XDEBUG=true
###< php-fpm ###
```

3) Ввести команды (вводить `docker-compose` или `docker compose` в зависимости от версии):

```bash
docker compose up -d --build
```

4) Установите зависимости после успешного запуска проекта:

```bash
docker compose exec php-fpm composer install
```

5) Войти в контейнер и запустить программу.

```bash
docker compose exec php-fpm php app.php
```

## Обоснование сложности

В моем случае `hasCycle` представляет собой алгоритм 
линейной сложности `O(n)`, поскольку требует перебора списка и памяти для 
хранения перебранных элементов в хэщ-таблице.
