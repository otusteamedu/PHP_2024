# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

# Создание индекса
``docker exec -it php-cli bash /app/elasticsearch/install.sh``

# Запрос в Elasticsearch
``docker exec -it php-cli php /app/app.php --index=otus-shop --search='рыцори' --minPrice=8000 --maxPrice=9000 --category=Детектив``
