FROM php:8.1-cli

WORKDIR /var/www/html

COPY . /var/www/html

RUN apt-get update && apt-get install -y \
    socat \
    && docker-php-ext-install sockets
