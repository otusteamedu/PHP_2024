FROM php:8.2-fpm

# ставим необходимые для нормальной работы модули
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libonig-dev \
        libzip-dev \
        libmcrypt-dev \
        libmemcached-dev \
        zlib1g-dev \
        libssl-dev \
        && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# Install Redis Memcached
RUN pecl install redis memcached && docker-php-ext-enable redis

WORKDIR /var/www/html

CMD ["php-fpm"]