FROM php:7.4-fpm

# ставим необходимые для нормальной работы модули
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libonig-dev \
        libzip-dev \
        && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
        && docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd

RUN pecl install redis \
    && docker-php-ext-enable redis

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]
