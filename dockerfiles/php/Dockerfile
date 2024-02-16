FROM php:8.2-fpm
LABEL authors="pavelsergeevich"

RUN apt-get update && apt-get install -y curl && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /data/app
ENTRYPOINT ["php-fpm"]