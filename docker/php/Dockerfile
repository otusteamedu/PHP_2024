FROM php:8.3.3-fpm


RUN apt-get update && apt-get install -y \
    curl \
    wget \
    git \
    libmcrypt-dev \
    zlib1g-dev \
    libmemcached-dev \
    libssl-dev \
    && pecl install memcached\
    && docker-php-ext-enable memcached

RUN docker-php-ext-install sockets

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet


COPY general.ini /usr/local/etc/php/conf.d/general.ini


WORKDIR /var/www/mysite.local

CMD ["php-fpm"]