FROM php:8.2-fpm

RUN apt-get update \
   && docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www/laravel-docker