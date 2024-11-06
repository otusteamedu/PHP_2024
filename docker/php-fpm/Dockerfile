FROM php:8.2-fpm

# ставим необходимые для нормальной работы модули
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libonig-dev \
        libzip-dev \
        libmemcached-dev \
        libmcrypt-dev \
        libssl-dev \
        && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
        && pecl install redis \
        && docker-php-ext-enable redis \
        && pecl install memcached-3.2.0 \
        && docker-php-ext-enable memcached

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini
COPY ./zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf

# устанавливаем composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]
