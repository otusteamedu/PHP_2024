# PHP_2023

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

# Redis App

```
    docker compose build
    docker compose up -d
    docker compose exec php-fpm bash
 ```   
    добавление event:
    php public/index.php add '{priority: 1000, conditions: {param1 = 1, param2 = 2}, event: {event1}}'
    php public/index.php add '{priority: 2000, conditions: {param1 = 2, param2 = 2}, event: {event2}}'
    php public/index.php add '{priority: 3000, conditions: {param1 = 1, param2 = 2}, event: {event3}}'

    поиск event:
    php public/index.php get '{ "param1": 1 }'

    удаление всех event:
    php public/index.php delete


