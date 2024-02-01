FROM php:8.3.2-fpm

RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libmemcached-dev \
    libssl-dev

RUN docker-php-ext-install pdo pdo_mysql  && docker-php-ext-enable pdo pdo_mysql

RUN pecl install redis memcached && docker-php-ext-enable redis memcached

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /data

CMD ["php-fpm"]