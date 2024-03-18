FROM php:7.4-fpm

RUN apt-get update  \
    && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
	libmemcached-dev \
	libmcrypt-dev \
    && docker-php-ext-install mysqli pdo_mysql zip

RUN pecl install memcached redis
RUN docker-php-ext-enable memcached redis

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /var/www/html/otus-edu.localhost

VOLUME /data

CMD ["php-fpm"]
