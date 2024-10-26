FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install zip \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pgsql pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/otus/hw13
