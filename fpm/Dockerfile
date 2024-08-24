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

# Создаем директорию для сокета и устанавливаем правильные права
RUN mkdir -p /var/run/php && chown www-data:www-data /var/run/php

# Копируем свой файл www.conf в контейнер
COPY ./www.conf /usr/local/etc/php-fpm.d/www.conf

# Dockerfile для PHP-FPM (fpm/Dockerfile)
RUN mkdir -p /usr/local/etc/php-fpm.d && \
    echo "listen = /var/run/php/php-fpm.sock" >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo "listen.owner = www-data" >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo "listen.group = www-data" >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo "listen.mode = 0660" >> /usr/local/etc/php-fpm.d/zz-docker.conf

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Устанавливаем PDO
RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql

# Устанавливаем текстовые редакторы
RUN apt-get update && apt-get install -y vim nano

WORKDIR /data

VOLUME /data

# Запускаем PHP-FPM
CMD ["php-fpm"]
