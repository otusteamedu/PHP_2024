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
    && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN git clone https://github.com/phpredis/phpredis.git /usr/src/phpredis \
    && cd /usr/src/phpredis \
    && phpize \
    && ./configure \
    && make && make install \
    && docker-php-ext-enable redis
# Устанавливаем Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY php.ini /usr/local/etc/php/conf.d/php-custom.ini
#COPY zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf
ENV COMPOSER_ALLOW_SUPERUSER=1


WORKDIR /data/application.local

COPY . .

RUN composer install && composer dump-autoload
CMD ["php-fpm"]
