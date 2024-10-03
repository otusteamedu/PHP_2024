FROM php:8.3-fpm-alpine

ARG PUID=1000
ARG PGID=1000

RUN apk --no-cache add shadow autoconf make zlib-dev libc-dev linux-headers \
    && docker-php-ext-install sockets \
    && docker-php-ext-enable sockets \
    && groupmod -o -g ${PGID} www-data \
    && usermod -o -u ${PUID} -g www-data www-data

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY ./zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf
COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /var/www
