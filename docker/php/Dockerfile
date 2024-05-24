FROM php:8.3-fpm

WORKDIR /var/www/app

RUN pecl install redis && docker-php-ext-enable redis.so \
    && apt-get update && apt-get install -y zlib1g-dev libzip-dev unzip && docker-php-ext-install zip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer