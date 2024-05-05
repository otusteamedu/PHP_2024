FROM php:8.2-cli

RUN docker-php-ext-install sockets pcntl

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY ./app /app

RUN composer install --no-interaction
