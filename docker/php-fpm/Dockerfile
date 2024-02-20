FROM php:8.2-fpm

RUN apt-get update && apt-get install --yes \
    git \
    zip \
    unzip \
    zlib1g-dev \
    libmemcached-dev \
    libssl-dev \
    && docker-php-ext-install mysqli pdo pdo_mysql  \
    && docker-php-ext-enable mysqli pdo pdo_mysql \
    && pecl install memcached-3.2.0 \
    && docker-php-ext-enable memcached

COPY ./config/php.ini /usr/local/etc/php/conf.d/php-custom.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app/application.local

CMD ["php-fpm"]
