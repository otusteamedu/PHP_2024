FROM php:8.3-fpm

WORKDIR /var/www/app

RUN pecl install redis && docker-php-ext-enable redis.so