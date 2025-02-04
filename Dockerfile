FROM php:8.2-alpine

RUN apk add --no-cache \
    libzip-dev \
    unzip \
    libmemcached-dev \
    zlib-dev \
    autoconf \
    # Для pecl/phpize
    build-base

# Установка PHP расширений
RUN docker-php-ext-install zip

# Установка Redis
RUN pecl install redis && docker-php-ext-enable redis

# Установка Memcached (для Alpine не нужны дополнительные параметры)
RUN pecl install memcached && docker-php-ext-enable memcached

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

ARG SOURCE_PATH=/var/www/html
WORKDIR $SOURCE_PATH
COPY . $SOURCE_PATH
RUN composer install --no-dev --optimize-autoloader

CMD ["php", "-S", "0.0.0.0:8000"]
