FROM php:8.3-fpm

WORKDIR /var/www/html/public

COPY ./php.ini /usr/local/etc/php/php.ini

RUN docker-php-ext-install sockets