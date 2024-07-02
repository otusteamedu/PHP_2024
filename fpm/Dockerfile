FROM php:8.3-fpm

# ставим необходимые для нормальной работы модули
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
        && pecl install memcached \
        && docker-php-ext-enable redis memcached \
        && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]
