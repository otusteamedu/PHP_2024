FROM php:8.2-cli
LABEL authors="hukimato"

RUN apt update && apt install -y \
    libonig-dev \
    && docker-php-ext-install -j$(nproc) mbstring \
    && docker-php-ext-install sockets

COPY ./config/php.ini /usr/local/etc/php/conf.d/php-custom.ini
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

#COPY ./app /app
VOLUME /sockets
VOLUME /var/log

CMD composer install; tail -f /dev/null;