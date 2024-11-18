FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
        git \
        unzip \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
	libmemcached-dev \
	libmcrypt-dev \
    libpq-dev \
        && docker-php-ext-install -j$(nproc) iconv mbstring pdo_pgsql zip \
        && pecl install redis \
        && docker-php-ext-enable redis \
        && pecl install memcache \
        && docker-php-ext-enable memcache


COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY ./php-fpm/zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf
COPY ./php-fpm/php.ini /usr/local/etc/php/conf.d/php-custom.ini
COPY ./code/composer.json /data/hw1.local/
COPY ./code/composer.lock /data/hw1.local/
COPY .env /data/hw1.local/

WORKDIR /data/hw1.local
VOLUME /data/hw1.local

RUN composer install

CMD ["php-fpm"]