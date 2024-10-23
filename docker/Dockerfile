FROM php:8.2-fpm

WORKDIR /data/elastic-fpm/

RUN apt update && apt install -y \
    libcurl4 \
    libcurl4-openssl-dev \libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libonig-dev \
    libpq-dev \
    libxml2-dev \
    libmemcached-dev \
    libmcrypt-dev \
    libzip-dev \
    zip \
    && pecl install mcrypt-1.0.6 \
    && docker-php-ext-enable mcrypt \
    && pecl install redis \
    && docker-php-ext-enable redis.so \
    && docker-php-ext-install -j$(nproc) iconv mbstring pdo_pgsql zip xml \
    && docker-php-ext-install zip\
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install curl

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY --from=composer:2.7.6 /usr/bin/composer /usr/local/bin/composer

WORKDIR /data/elastic-fpm/code/src/Elastic
RUN composer require elasticsearch/elasticsearch

WORKDIR /data/elastic-fpm/code/src/View
RUN composer require phplucidframe/console-table

WORKDIR /data/elastic-fpm/
CMD ["php-fpm"]