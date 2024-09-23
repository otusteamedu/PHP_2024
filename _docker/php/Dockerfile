FROM php:8.3-fpm-alpine

ARG PUID=1000
ARG PGID=1000

RUN apk --no-cache add build-base shadow autoconf make zlib-dev \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && groupmod -o -g ${PGID} www-data \
    && usermod -o -u ${PUID} -g www-data www-data

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /var/www

EXPOSE 9000

CMD ["php-fpm"]
