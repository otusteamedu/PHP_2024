FROM php:8.2-fpm

#EXPOSE 9000

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
	libmemcached-dev \
	zlib1g-dev \
	libssl-dev \
    && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
	&& docker-php-ext-configure sockets \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && pecl install redis && docker-php-ext-enable redis \
    && pecl install -f memcached-3.2.0 && docker-php-ext-enable memcached \
    && pecl install xdebug && docker-php-ext-enable xdebug \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


WORKDIR /data
COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

CMD ["php-fpm"]
