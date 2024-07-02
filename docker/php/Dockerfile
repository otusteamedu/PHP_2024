FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    && docker-php-ext-install sockets \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \

WORKDIR /var/www