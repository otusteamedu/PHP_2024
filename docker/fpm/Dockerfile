FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
        curl \
        wget \
        git \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libonig-dev \
        libzip-dev \
        libmcrypt-dev \
        && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
        && docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd \
        && pecl install mcrypt && docker-php-ext-enable mcrypt \
        && pecl install redis && docker-php-ext-enable redis \
        && echo "extension=redis.so" > /usr/local/etc/php/conf.d/redis.ini \
        && pecl install memcache && docker-php-ext-enable memcache \
        && echo "extension=memcache.so" > /usr/local/etc/php/conf.d/memcache.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]
