FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
        git \
        zip \
        unzip \
        curl \
        libzip-dev \
        libpng-dev \
        libjpeg-dev \
        libmemcached-dev \
        libonig-dev \
    	libzip-dev \
        libpq-dev \
        libmcrypt-dev \
        libfreetype6-dev \
        && docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install gd \
        && docker-php-ext-install iconv mbstring pdo pdo_pgsql


COPY ./php.ini /usr/local/etc/php/php.ini


EXPOSE 9000

WORKDIR /data

CMD ["php-fpm"]


