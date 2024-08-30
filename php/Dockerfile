FROM php:8.2-fpm

# Установка необходимых расширений и утилит
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libicu-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    git \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install intl zip \
    && pecl install redis \
    && docker-php-ext-enable redis

COPY php.ini /usr/local/etc/php/php.ini
