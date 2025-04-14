# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

добавим .env

docker-compose up --build -d

docker compose exec -it app bash

composer install
composer require elasticsearch/elasticsearch

php artisan migrate
php artisan db:seed
php artisan search:reindex:youtubechannels



для удаления каналов
php artisan search:delete:youtubechannels


.env
ELASTICSEARCH_ENABLED=true 
