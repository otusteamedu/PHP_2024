# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

## Usage

`docker-compose up -d`

`cp .env.example .env`

Установка зависимостей:
`docker exec -it php-fpm /bin/bash -c 'composer install'`

Генерация OpenApi документации:
`docker exec -it php-fpm /bin/bash -c 'php generate-openapi.php > openapi.json'`

Navigate to `http://localhost`

Swagger UI:
`http://localhost/swagger`
