FROM composer:2.2 as composer_builder

FROM php:8.0-fpm

# ставим необходимые для нормальной работы модули
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
#	libmemcached-dev \
#	libmcrypt-dev \
#        && pecl install mcrypt-1.0.3 \
#	&& docker-php-ext-enable mcrypt \
        && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd
#     && pecl install memcached && \
#        docker-php-ext-enable memcached

RUN      pecl install redis \
         && docker-php-ext-enable redis
COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

COPY --from=composer_builder /usr/bin/composer /usr/bin/composer

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]
