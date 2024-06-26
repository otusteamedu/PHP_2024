FROM php:7.4-fpm

# ставим необходимые для нормальной работы модули
RUN apt-get update && apt-get install -y \
        curl \
        wget \
        git \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
    libmemcached-dev \
	libmcrypt-dev \
        && pecl install mcrypt-1.0.3 \
	&& docker-php-ext-enable mcrypt \
        && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd 

# Установка расширения memcahed
RUN pecl install memcached && docker-php-ext-enable memcached

# Установка расширения redis
RUN pecl install redis && docker-php-ext-enable redis

# Настроить php-fpm для использования Unix-сокета
RUN sed -i "s|listen = 127.0.0.1:9000|listen = /var/run/php/php-fpm.sock|" /usr/local/etc/php-fpm.d/www.conf

# Установить правильные права на сокет
RUN sed -i "s|;listen.owner = www-data|listen.owner = www-data|" /usr/local/etc/php-fpm.d/www.conf \
    && sed -i "s|;listen.group = www-data|listen.group = www-data|" /usr/local/etc/php-fpm.d/www.conf \
    && sed -i "s|;listen.mode = 0660|listen.mode = 0660|" /usr/local/etc/php-fpm.d/www.conf

RUN mkdir -p /var/run/php && chown www-data:www-data /var/run/php

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Устанавливаем PDO
RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]
