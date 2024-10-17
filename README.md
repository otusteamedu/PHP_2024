# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

Приложение принимает заявки на проведение мероприятий.
Уведомление об обработке заявки отправляется на почту.

## Подготовка приложения
```shell
cd project dir
docker compose build
docker compose up -d
docker exec -ti app  /bin/bash -c "cd /data/mysite.local && composer install"
```

## Запуск консьюмера
```shell
docker exec -ti app /bin/bash -c "cd /data/mysite.local && php consumer.php"
```

## Отладка
Админ панель находится по адресу http://localhost:8030

## Описание Api
[Cпецификация Api](/code/openapi.yml)