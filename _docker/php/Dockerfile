FROM php:8.3-fpm-alpine

ARG PUID=1000
ARG PGID=1000

RUN apk --no-cache add shadow postgresql-dev libmemcached-dev autoconf make zlib-dev \
    && docker-php-ext-install pdo_pgsql \
    && pecl install redis memcached \
    && docker-php-ext-enable redis memcached \
    && groupmod -o -g ${PGID} www-data \
    && usermod -o -u ${PUID} -g www-data www-data

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /var/www

EXPOSE 9000

CMD ["php-fpm"]