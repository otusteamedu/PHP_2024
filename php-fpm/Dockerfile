FROM php:8.2-fpm

# Установка зависимостей для расширений PHP и других пакетов
RUN apt-get update && apt-get install -y \
        libmemcached-dev \
        libz-dev \
        libpq-dev \
        libjpeg-dev \
        libpng-dev \
        libfreetype6-dev \
        libssl-dev \
        libmcrypt-dev \
        libzip-dev \
        zlib1g-dev \
        unzip \
    # Очищаем кеш apt-get для уменьшения размера образа
    && rm -rf /var/lib/apt/lists/*

# Конфигурируем и устанавливаем расширения PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mysqli zip gd

# Установка расширения Memcached через PECL
RUN pecl install memcached \
    && docker-php-ext-enable memcached

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
