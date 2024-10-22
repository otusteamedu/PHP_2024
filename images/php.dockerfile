FROM php:8.2-fpm

RUN apt-get update && apt-get install -y libmemcached-dev zlib1g-dev libssl-dev

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

RUN pecl install redis-6.0.2 \
    && docker-php-ext-enable redis

RUN pecl install memcached-3.2.0 \
    && docker-php-ext-enable memcached