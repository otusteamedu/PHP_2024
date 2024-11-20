FROM php:8.1-cli

RUN apt-get update \
    && docker-php-ext-install sockets \
    && docker-php-ext-enable sockets \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html