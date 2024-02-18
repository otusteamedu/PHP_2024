FROM php:8.2-fpm

WORKDIR /var/www/app

RUN apt-get update && apt-get install -y zlib1g-dev libmemcached-dev g++ git libicu-dev zip libzip-dev libpq-dev \
    && pecl install memcached \
    && docker-php-ext-enable memcached \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer