FROM php:8.2-fpm-alpine

RUN apk update && apk add --no-cache --virtual .build-temp-deps \
      autoconf make gcc g++ zlib-dev \
    && apk update && apk add --no-cache libmemcached-dev \
    #memcache
    && pecl install memcache \
    && docker-php-ext-enable memcache \
    #composer
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet \
    && rm -rf /root/.composer/cache \
    && apk del --no-cache -f .build-temp-deps

COPY ./php/conf.d /usr/local/etc/php/conf.d

WORKDIR /hw4/app