FROM php:8.4-fpm

# Установка зависимостей
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    libmcrypt-dev \
    zlib1g-dev \
    libssl-dev

# Остальные настройки... \
# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# Install Redis Memcached
RUN pecl install redis && docker-php-ext-enable redis
RUN pecl install mongodb && docker-php-ext-enable mongodb

WORKDIR /var/www/html

CMD ["php-fpm"]