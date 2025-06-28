FROM php:8.1-fpm

# ставим необходимые для нормальной работы модули
RUN set -eux; \
    apt-get update; \
    apt-get upgrade -y; \
    apt-get install -y --no-install-recommends \
            curl \
            libmemcached-dev \
            libz-dev \
            libpq-dev \
            libjpeg-dev \
            libpng-dev \
            libfreetype6-dev \
            libssl-dev \
            libwebp-dev \
            libxpm-dev \
            libmcrypt-dev \
            libonig-dev; \
    rm -rf /var/lib/apt/lists/*

RUN set -eux; \
    # Install the PHP pdo_mysql extention
    docker-php-ext-install pdo_mysql; \
    # Install the PHP gd library
    docker-php-ext-configure gd \
            --prefix=/usr \
            --with-jpeg \
            --with-webp \
            --with-xpm \
            --with-freetype; \
    docker-php-ext-install gd;

# Установим зависимости и расширение redis
RUN apt-get update && apt-get install -y \
        libzip-dev \
        zip \
        unzip \
        && docker-php-ext-install zip \
        && pecl install redis \
        && docker-php-ext-enable redis

# Устанавливаем Composer \
COPY --from=composer:2 --link /usr/bin/composer /usr/local/bin/composer

WORKDIR /data

CMD ["php-fpm"]
