FROM php:8.2-cli-alpine

RUN apk update && apk add --no-cache --virtual .build-temp-deps \
    autoconf bash make gcc g++ freetype-dev libtool \
    #phpredis \
    && pecl install redis \
    && docker-php-ext-enable redis.so \
    # Composer install
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet \
    && rm -rf /root/.composer/cache

WORKDIR /app