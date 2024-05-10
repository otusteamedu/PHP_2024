FROM php:8.2-cli

RUN docker-php-ext-install sockets pcntl

WORKDIR /app
COPY ./app /app