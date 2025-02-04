FROM php:8.2-alpine

RUN apk add --no-cache \
    libzip-dev \
    unzip \
    libmemcached-dev \
    zlib-dev \
    autoconf \
    build-base \
    && docker-php-ext-install zip \
    && pecl install redis && docker-php-ext-enable redis \
    && pecl install memcached && docker-php-ext-enable memcached

RUN curl -sS https://getcomposer.org/installer | php --  --install-dir=/usr/local/bin --filename=composer

ARG SOURCE_PATH=/var/www/html
WORKDIR $SOURCE_PATH
COPY . $SOURCE_PATH
RUN composer install --no-dev --optimize-autoloader

CMD ["php", "-S", "0.0.0.0:8000"]
