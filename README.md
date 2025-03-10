# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

## Usage

`docker-compose up -d`

`cp .env.example .env`

Установка зависимостей:
`docker exec -it php-fpm /bin/bash -c 'composer install'`

Navigate to `http://localhost`

MailHog UI `http://localhost:8025`

Контейнер Consumer'а очередей:
`docker exec -it php-worker /bin/bash`

Файл Consumer'а очередей:
`src/app/Infrastructure/Workers/Worker.php`
