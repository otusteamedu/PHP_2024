# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

### Загрузка данных в elastic :

    docker exec -it app php /app/public/index.php init

### Формат запроса данных:

    docker exec -it app php /app/public/index.php query [prop]=[val] [prop]=[val]

Примеры запросов:

    docker exec -it app php /app/public/index.php query title=рыцори 
    docker exec -it app php /app/public/index.php query sku=033
    docker exec -it app php /app/public/index.php query price_min=5100 price_max=6100
