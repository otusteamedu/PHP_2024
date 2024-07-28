FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    curl \
    zlib1g-dev \
    libzip-dev \
    supervisor \
    libssl-dev \
    unzip \
    && docker-php-ext-install -j$(nproc) \
    pgsql \
    pdo_pgsql \
    zip \
    sockets \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug sockets

COPY ./supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

#Installing composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN rm -rf composer-setup.php

CMD ["php-fpm"]
