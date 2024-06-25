FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
    && docker-php-ext-install sockets

WORKDIR /data

CMD ["php-fpm"]