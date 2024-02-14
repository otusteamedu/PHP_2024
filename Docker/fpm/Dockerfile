FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
        curl \
        wget \
        git \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
        && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd \
    && mkdir -p /run/php

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY php.ini /usr/local/etc/php/conf.d/php-custom.ini
COPY zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf


WORKDIR /data

VOLUME /data

CMD ["php-fpm"]
