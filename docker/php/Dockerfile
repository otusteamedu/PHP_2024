FROM php:8.2-fpm-alpine

RUN apk update && apk add --no-cache --virtual .build-temp-deps \
      autoconf make gcc g++ zlib-dev \
    && apk update && apk add --no-cache \
      postgresql-dev libmemcached-dev \
    #postgres
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql \
    #composer
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet \
    && rm -rf /root/.composer/cache \
    && apk del --no-cache -f .build-temp-deps

COPY ./php/conf.d /usr/local/etc/php/conf.d

WORKDIR /app