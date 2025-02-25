# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

## Usage

`cp .env.example .env`

`docker-compose up -d`

Navigate to `http://localhost`

## Run Tests

Enter php container:
`docker exec -it php-fpm sh`

Run tests:
`vendor/bin/phpunit --coverage-text`
