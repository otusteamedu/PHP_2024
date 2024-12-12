FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
        git \
        unzip \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
	libmemcached-dev \
	libmcrypt-dev \
    libpq-dev \
        && docker-php-ext-install -j$(nproc) iconv mbstring zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY ./code/composer.json /data/hw5/

WORKDIR /data/hw5