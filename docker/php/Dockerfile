FROM php:8.2-fpm-alpine

RUN apk update && apk add --no-cache --virtual .build-temp-deps \
    autoconf bash make gcc g++ freetype-dev libtool \
    linux-headers \
    rabbitmq-c rabbitmq-c-dev \
    && docker-php-ext-install sockets \
    # Composer install
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet \
    && rm -rf /root/.composer/cache \
    # amqp install
    && pecl install amqp \
    && docker-php-ext-enable amqp

WORKDIR /app