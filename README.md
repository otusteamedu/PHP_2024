# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

# Добавление записи
``docker exec -it otus-php-cli php /app/app.php --command add --params='{"priority":3000,"param1":1,"param2":2}'``

# Очистка
``docker exec -it otus-php-cli php /app/app.php --command clear``

# Получение записи
``docker exec -it otus-php-cli php /app/app.php --command get --params='{"param1":1,"param2":2}'``
