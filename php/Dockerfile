FROM php:8.2-fpm

RUN apt-get update \
    && docker-php-ext-install pdo pdo_mysql \
    && apt-get install -y libmemcached-dev zlib1g-dev libssl-dev \
    && pecl install memcached && docker-php-ext-enable memcached \
    && pecl install redis && docker-php-ext-enable redis

COPY --from=composer /usr/bin/composer /usr/bin/composer