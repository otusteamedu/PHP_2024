# PHP_2024

Запуск приложения
1. Запуск контейнеров:
   

   `docker-compose up -d --build`


2. Для заполнения индекса выполняем команду:

    `docker exec -it php-fpm curl --location --insecure --request POST 'elasticsearch:9200/_bulk' --header 'Content-Type: application/json' --data-binary "@app/books.json"`




3. Для проверки скрипта запускаем команду c параметрами (или без, тогда вернутся все записи в наличии)

`docker exec -it php-fpm php app/index.php category="Исторический роман" price="200-1000" title="рыцОри"`
