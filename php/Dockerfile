FROM php:8.2-fpm

RUN apt-get update \
    && docker-php-ext-install pdo pdo_mysql \
    && apt-get install -y libmemcached-dev zlib1g-dev libssl-dev libzip-dev zip\
    && docker-php-ext-install zip sockets bcmath

COPY --from=composer /usr/bin/composer /usr/bin/composer