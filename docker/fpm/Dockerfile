FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    curl \
    zlib1g-dev \
    libzip-dev \
    libssl-dev \
    unzip \
    && docker-php-ext-install -j$(nproc) \
    zip \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

#Installing composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN rm -rf composer-setup.php

CMD ["php-fpm"]
