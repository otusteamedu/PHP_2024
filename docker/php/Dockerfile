FROM php:8.3-fpm

WORKDIR /var/www/app

RUN apt-get update && apt-get install -y zlib1g-dev libmemcached-dev g++ git libicu-dev zip libzip-dev libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install intl opcache pdo pdo_pgsql pgsql \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer