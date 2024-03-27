FROM php:8.2-cli
LABEL authors="hukimato"

RUN apt update && apt install -y \
    libonig-dev \
    libzip-dev \
    && docker-php-ext-install -j$(nproc) mbstring zip

COPY ./php/php.ini /usr/local/etc/php/conf.d/php-custom.ini
COPY ./http_ca.crt /cert/http_ca.crt
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
VOLUME /var/log

CMD composer install; tail -f /dev/null;