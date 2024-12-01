FROM php:8.3-fpm-alpine

# Install packages
RUN apk add --no-cache curl git build-base zlib-dev oniguruma-dev autoconf bash
RUN apk add --update linux-headers

# Postgres
RUN apk add --no-cache libpq-dev && docker-php-ext-install pdo_pgsql

# Source code
WORKDIR /var/www/otus-hw-15

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

CMD ["php-fpm"]
