# PHP_2024

1. docker-compose pull
2. docker-compose build
3. docker-compose run php-fpm chmod 777 -R /app/var
4. docker-compose run php-fpm composer install
5. docker-compose run php-fpm php bin/console doctrine:database:create
6. docker-compose run php-fpm php bin/console doctrine:migrations:migrate
7. docker-compose up -d



https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus
