FROM php:8.2-fpm

RUN apt-get update && apt-get install --yes \
    zlib1g-dev \
    libmemcached-dev \
    libssl-dev

RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli pdo pdo_mysql

RUN pecl install redis-6.0.2 && \
    pecl install memcached-3.2.0 && \
	docker-php-ext-enable redis memcached

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer