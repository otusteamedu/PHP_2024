FROM php:8.1-cli

RUN apt-get update \
    && apt-get install -y unzip \
    && docker-php-ext-install sockets \
    && docker-php-ext-enable sockets \
    && pecl install xdebug-3.3.2 \
    && docker-php-ext-enable xdebug \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html