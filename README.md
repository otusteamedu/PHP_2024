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
После этого приложение готово к приему http запросов.
Пример запроса.
```shell
curl --request POST \
  --url http://mysite.local/ \
  --header 'Content-Type: multipart/form-data' \
  --cookie PHPSESSID=de598cc8a78965c5ea1031834a7e8842 \
  --form name=Peter \
  --form email=example@example.com \
  --form 'eventDate=2024-11-01 12:00' \
  --form address=addres \
  --form guest=2
```

## Запуск консьюмера
```shell
docker exec -ti app /bin/bash -c "cd /data/mysite.local && php consumer.php"
```

## Отладка
Админ панель находится по адресу http://localhost:8030
Просмотреть письма отправленные приложением можно по адресу http://localhost:8025