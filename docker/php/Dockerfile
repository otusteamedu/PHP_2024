FROM php:8.2-fpm

WORKDIR /app

RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip \
    libpq-dev \
    curl \
    git \
    && docker-php-ext-install pdo pdo_pgsql zip sockets

# Установка Xdebug
RUN pecl install xdebug \
&& docker-php-ext-enable xdebug

#загружаем composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    chmod +x /usr/local/bin/composer

CMD ["php-fpm"]
