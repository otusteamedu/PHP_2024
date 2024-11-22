FROM php:8.3-fpm

RUN set -x \
        && deluser www-data \
        && addgroup -gid 500 --system www-data \
        && adduser -uid 500 --system --disabled-login --disabled-password --gid 500 www-data

RUN apt-get update --fix-missing && apt-get install -y \
    zip \
    libicu-dev \
    libzip-dev \
    libssl-dev \
    libmemcached-dev \
    libmcrypt-dev \
    && docker-php-ext-install -j$(nproc) iconv mysqli pdo_mysql zip intl sockets

RUN pecl install redis \
    && docker-php-ext-enable redis

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]