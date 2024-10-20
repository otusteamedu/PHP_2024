FROM php:8.1-cli

WORKDIR /app

COPY . .

RUN apt-get update && apt-get install -y \
    && docker-php-ext-install sockets
