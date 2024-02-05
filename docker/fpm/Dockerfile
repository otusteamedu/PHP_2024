FROM php:8.3.2-fpm


RUN apt-get update && apt-get install -y \
    curl \
    wget \
    git \
    libmcrypt-dev \
    zlib1g-dev \
    libmemcached-dev \
    libssl-dev \
    && pecl install redis memcached\
    && docker-php-ext-install pdo pdo_mysql \
    && docker-php-ext-enable pdo pdo_mysql redis memcached

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet


COPY php.ini /usr/local/etc/php/conf.d/php-custom.ini


WORKDIR /data

CMD ["php-fpm"]
