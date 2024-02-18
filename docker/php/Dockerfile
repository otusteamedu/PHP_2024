FROM php:8.2-cli-alpine

RUN apk update && apk add --no-cache --virtual .build-temp-deps \
      autoconf make gcc g++ zlib-dev \
    #sockets
      linux-headers \
    && docker-php-ext-install sockets \
    #composer
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet \
    && rm -rf /root/.composer/cache \
    && apk del --no-cache -f .build-temp-deps

COPY ./php/conf.d /usr/local/etc/php/conf.d

WORKDIR /hw/app