FROM php:8.3-fpm

WORKDIR /app

RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip \
    libpq-dev \
    curl \
    git \
    && docker-php-ext-install pdo pdo_pgsql zip sockets

# Установка Xdebug
RUN pecl install xdebug-3.3.1 \
&& docker-php-ext-enable xdebug

# Настройка Xdebug для coverage
RUN echo "xdebug.mode=coverage" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.start_with_request=trigger" >> /usr/local/etc/php/conf.d/xdebug.ini

#загружаем composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    chmod +x /usr/local/bin/composer

CMD ["php-fpm"]