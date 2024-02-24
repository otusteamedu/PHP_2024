FROM php:8.3

RUN apt-get update && apt-get install -y \
    zip \
    && docker-php-ext-install sockets

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /data/mysite.local

COPY . .

RUN composer install --optimize-autoloader

WORKDIR /data/mysite.local/app