FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
    libmemcached-dev \
	libmcrypt-dev \
	zlib1g-dev \
	libssl-dev \
    && pecl install mcrypt-1.0.7 \
    && docker-php-ext-enable mcrypt \
    && pecl install memcached-3.2.0 \
    && docker-php-ext-enable memcached \
    && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install sockets \
    && docker-php-ext-enable sockets \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /socket

CMD ["php-fpm"]