FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
        curl \
        wget \
        git \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libonig-dev \
        libzip-dev \
        libpq-dev \
        libmemcached-dev \
        && docker-php-ext-install -j$(nproc) iconv mbstring pdo_pgsql zip \
        && docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd \
        && pecl install redis \
        && docker-php-ext-enable redis \
        && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

VOLUME /var/www

CMD ["php-fpm"]
