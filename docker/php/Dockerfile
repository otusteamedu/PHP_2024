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

# Install the PHP mbstring extention
# RUN docker-php-ext-install mbstring

# Install the PHP pdo_mysql extention
# RUN docker-php-ext-install pdo_mysql

# Install the PHP pdo_pgsql extention
# RUN docker-php-ext-install pdo_pgsql pgsql && docker-php-ext-enable pgsql

# Install the php redis extension
# RUN pecl install redis && docker-php-ext-enable redis

# Install the php memcached extension
# RUN pecl install memcached && docker-php-ext-enable memcached

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./docker/php/php.ini "$PHP_INI_DIR/php.ini"