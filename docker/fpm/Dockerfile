FROM php:8.2-fpm

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apt-get update && apt-get install -y \
        libpq-dev \
        zlib1g-dev \
        libzip-dev \
        libmemcached-dev \
        libssl-dev \
        && docker-php-ext-install -j$(nproc) \
        mysqli \
        pdo_mysql \
        zip \
        && pecl install memcached \
        && docker-php-ext-enable memcached \
        && docker-php-ext-install pdo pdo_pgsql pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

CMD composer install;php-fpm