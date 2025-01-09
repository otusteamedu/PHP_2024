FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libmemcached-dev \
    zip \
    libzip-dev \
    && docker-php-ext-install pgsql pdo_pgsql zip \
    && pecl install redis \
    && pecl install memcached \
    && docker-php-ext-enable redis memcached

RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

ARG SOURCE_PATH=/var/www
WORKDIR $SOURCE_PATH
COPY . $SOURCE_PATH

EXPOSE 9000

ENTRYPOINT ["sh", "./entrypoint.sh"]
