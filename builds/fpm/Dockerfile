FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    libmemcached-dev \
    libmcrypt-dev \
    libssl-dev \
    pkg-config \
    unzip \
    git \
    && docker-php-ext-install -j$(nproc) iconv mbstring

RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pgsql pdo_pgsql pdo

# Установить Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Перейти в рабочую директорию и установить php-http через Composer
WORKDIR /data

# Создать файл composer.json для установки библиотеки php-http
RUN echo '{"require": {"php-http/curl-client": "^2.0", "php-http/message": "*"}, "minimum-stability": "dev", "prefer-stable": true}' > composer.json
RUN composer install --no-dev

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

VOLUME /data

CMD ["php-fpm"]
