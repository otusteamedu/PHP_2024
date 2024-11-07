FROM php:8.3-fpm

RUN mkdir -p /var/www/html

WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    libzip-dev \
    libz-dev \
    libmemcached-dev \
    libssl-dev \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Install the PHP pdo_mysql extention
RUN docker-php-ext-install pdo_mysql

# Install the php redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Install the php memcached extension
RUN pecl install memcached && docker-php-ext-enable memcached