FROM php:8.3-fpm

RUN mkdir -p /var/www/html

WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    libzip-dev \
    libz-dev \
    libmemcached-dev \
    libssl-dev \
    libpq-dev \
    unzip \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Install the PHP zip extention
RUN docker-php-ext-install zip

# Install the PHP sockets extention
RUN docker-php-ext-install sockets && docker-php-ext-enable sockets

# Install the PHP pdo_mysql extention
# RUN docker-php-ext-install pdo_mysql

# Install the PHP pdo_pgsql extention
# RUN docker-php-ext-install pdo_pgsql pgsql && docker-php-ext-enable pgsql

# Install the php redis extension
# RUN pecl install redis && docker-php-ext-enable redis

# Install the php memcached extension
# RUN pecl install memcached && docker-php-ext-enable memcached

# Install the Xdebug extension
# RUN pecl install xdebug

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./docker/php/fpm-pool.conf "$PHP_INI_DIR/php-fpm.d/www.conf"
COPY ./docker/php/php.ini "$PHP_INI_DIR/php.ini"