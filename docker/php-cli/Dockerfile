FROM php:8.3-cli

WORKDIR /socketapp

RUN apt-get update --fix-missing && apt-get install -y \
        libzip-dev \
        && docker-php-ext-install -j$(nproc) zip sockets

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer self-update