FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    && docker-php-ext-install sockets

WORKDIR /data