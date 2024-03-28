FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
        curl \
        wget \
        git \
        nano \
        libpng-dev libxpm-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        libwebp-dev \
        libfreetype-dev \
    && docker-php-ext-configure gd --with-jpeg=/usr/include/ --with-webp=/usr/include/ --with-freetype=/usr/include/ \
    && docker-php-ext-install gd \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && docker-php-ext-install sockets \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && pecl clear-cache \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && rm "$PHP_INI_DIR/php.ini-development"