FROM php:8.3-fpm

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        apt-utils \
        libpq-dev \
        libpng-dev \
        libzip-dev \
        zip \
        unzip \
        git \
        libmemcached-dev \
        libz-dev \
        libssl-dev \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql bcmath gd zip sockets calendar

RUN pecl install redis \
    && docker-php-ext-enable redis

RUN pecl install memcached \
    && docker-php-ext-enable memcached

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer



COPY ./_docker/app/php.ini /usr/local/etc/php/conf.d/php.ini

WORKDIR /var/www

RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www
