# PHP_2024

*1. Запуск nginx, php-fpm, rabbitmq*

 - Запускаем `docker-compose up -d --build`


*2. Запуск Consumer*

 - Запускаем Consumer в командной строке `docker exec -it consumer php app/index.php`

*3. Отправляем POST-запрос с полями "date_from" и "date_to" в формате DD-MM-YYYY*