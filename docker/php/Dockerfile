FROM php:8.3.2-fpm

RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libmemcached-dev \
    libssl-dev \
    git \
 && pecl install memcached && docker-php-ext-enable memcached \
 && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
 && apt-get clean

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /data

EXPOSE 9000

CMD ["php-fpm"]