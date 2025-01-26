FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
	libmemcached-dev \
	libmcrypt-dev \
    libssl-dev pkg-config unzip git \
    && docker-php-ext-install -j$(nproc) iconv mbstring

RUN pecl install redis \
        && rm -rf /tmp/pear \
        && docker-php-ext-enable redis\
        && pecl install zlib zip mongodb \
        && docker-php-ext-enable mongodb

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]
