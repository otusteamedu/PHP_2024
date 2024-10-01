FROM php:8.2-fpm

# Установка необходимых расширений и утилит
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libicu-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    git \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install intl zip \
    && pecl install redis \
    && docker-php-ext-enable redis

COPY ../composer.json /var/www/html/src/composer.json

COPY ../src /var/www/html/src

COPY ../vendor /var/www/html/vendor

WORKDIR /var/www/html

# Добавляем конфигурацию для хранения сессий в Redis
RUN echo "session.save_handler = redis" > /usr/local/etc/php/conf.d/redis-session.ini
RUN echo "session.save_path = \"tcp://redis:6379\"" >> /usr/local/etc/php/conf.d/redis-session.ini

COPY php/php.ini /usr/local/etc/php/php.ini

