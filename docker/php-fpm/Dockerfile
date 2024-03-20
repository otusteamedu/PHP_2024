FROM php:8.2-fpm


# ставим необходимые для нормальной работы модули
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libonig-dev \
        libzip-dev \
        libmemcached-dev \
        zlib1g-dev \
        libssl-dev \
        && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip\
        && pecl install redis memcached\
        && docker-php-ext-enable  redis memcached

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY www.conf /usr/local/etc/php-fpm.d/www.conf
COPY sock.conf /usr/local/etc/php-fpm.d/zz-docker.conf


WORKDIR /data


CMD ["php-fpm"]
