FROM php:8.2-fpm

RUN apt-get update && apt-get install --yes \
    git \
    zip \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./config/php.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /var/www/application.local