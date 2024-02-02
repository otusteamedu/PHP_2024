# https://serverfault.com/questions/1134001/memcached-support-requires-libmemcached
FROM php:8.2-fpm-bullseye
LABEL authors="hukimato"

RUN apt update && apt install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    libpq-dev \
    libxml2-dev \
    libmemcached-dev \
    libmcrypt-dev \
    && pecl install mcrypt-1.0.6 \
    && docker-php-ext-enable mcrypt \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && pecl install memcached \
    && docker-php-ext-enable memcached \
    && docker-php-ext-install -j$(nproc) iconv mbstring pdo_pgsql zip xml \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /www/mysite.local

VOLUME /www/mysite.local

CMD composer install; php-fpm