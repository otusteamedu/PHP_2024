FROM php:8.1-cli

RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev \
    libzip-dev \
    && docker-php-ext-install zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /data/public