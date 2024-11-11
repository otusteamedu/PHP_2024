# Используем базовый образ PHP с FPM
FROM php:8.0-fpm

# Install dependencies required for Memcached
RUN apt-get update && apt-get install -y \
    libmemcached-dev \
    zlib1g-dev \
    && pecl install memcached \
    && docker-php-ext-enable memcached \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*


# Установка необходимых PHP-расширений
RUN docker-php-ext-install pdo_mysql
