FROM php:8.1-cli

RUN apt-get update \
    && apt-get install -y zip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html