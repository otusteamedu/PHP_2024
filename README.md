# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

## Подготовка и запуск приложения
```
cd <project folder>
docker compose build .
docker run -v "./code:/data/mysite.local" -ti php_app /bin/bash -c "cd /data/mysite.local && composer install"
docker compose up
применить скрипт dump.sql к целевой БД
```

## Настройка приложения
Настройка приложения осуществляется посредством файла app.ini.