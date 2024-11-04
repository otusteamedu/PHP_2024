FROM php:8.2.12-fpm

RUN apt-get update && apt-get install -y  curl \
    libmemcached-dev \
    libz-dev \
    libzip-dev \
    libpq-dev \
    libonig-dev \
    libcurl4-openssl-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring curl zip \
    && pecl install redis memcached && docker-php-ext-enable redis memcached

COPY ./memcache.ini /usr/local/etc/php/conf.d/memcache.ini

WORKDIR /data/localhost

