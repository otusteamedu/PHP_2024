FROM php:8.2-fpm

WORKDIR /var/www/app

RUN pecl install redis \
    && docker-php-ext-enable redis.so \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer