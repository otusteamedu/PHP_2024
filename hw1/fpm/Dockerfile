FROM php:8.3-fpm

ARG XDEBUG_REMOTE_IP
ENV XDEBUG_REMOTE_IP ${XDEBUG_REMOTE_IP}

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libonig-dev \
        libzip-dev \
        libmemcached-dev \
        libmcrypt-dev \
    && pecl install  \
        mcrypt-1.0.7 \
        xdebug-3.3.1 \
	&& docker-php-ext-enable  \
        mcrypt \
        xdebug \
    && docker-php-ext-install -j$(nproc)  \
        iconv  \
        mbstring  \
        mysqli  \
        pdo_mysql  \
        zip \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

#     && pecl install memcached && \
#        docker-php-ext-enable memcached

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]
