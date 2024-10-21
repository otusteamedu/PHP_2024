# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

# Redis

## Добавление события

### Формат команды:
    docker exec -it app php /app/public/index.php add events '{priority:`val`, conditions: {`key` = `val`, ...}, event: {`event`}}'

### Примеры:
    docker exec -it app php /app/public/index.php add events '{priority: 1000, conditions: {param1 = 1}, event: {::event1::}}'
    // 1
    docker exec -it app php /app/public/index.php add events '{priority: 2000, conditions: {param1 = 1, param2 = 2}, event: {::event2::}}'
    // 1
    docker exec -it app php /app/public/index.php add events '{priority: 3000, conditions: {param1 = 1, param2 = 2}, event: {::event3::}}'
    // 1

## Поиск события
### Формат команды:
    docker exec -it app php /app/public/index.php get events '{params: {`key` = `val`, ...}}'

### Пример:
    docker exec -it app php /app/public/index.php get events '{params: {param1 = 1, param2 = 2}}'
    // ::event3::

## Очистка событий

    docker exec -it app php /app/public/index.php clear events
    // 1
