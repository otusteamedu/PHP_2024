FROM php:8.3-fpm

RUN apt-get update --fix-missing && apt-get install -y \
    zip \
    libicu-dev \
    libzip-dev \
    libssl-dev \
    libmemcached-dev \
    libmcrypt-dev \
    && docker-php-ext-install -j$(nproc) iconv mysqli pdo_mysql zip intl

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer self-update

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /app

VOLUME /app

CMD ["php-fpm"]