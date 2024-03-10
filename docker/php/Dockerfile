FROM php:8.1-fpm

RUN docker-php-ext-install pcntl

RUN docker-php-ext-install sockets

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

CMD composer install;php-fpm