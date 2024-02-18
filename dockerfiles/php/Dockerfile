FROM php:8.2-fpm
LABEL authors="pavelsergeevich"

#CURL
RUN apt-get update && apt-get install -y curl

#CLI

#PDO
RUN docker-php-ext-install pdo pdo_mysql

#Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#Memcached (Важно проверить наличие zlib)
RUN apt-get install -y libssl-dev zlib1g-dev libzip-dev libmemcached-dev
RUN pecl install memcached
RUN docker-php-ext-enable memcached

WORKDIR /data/app
ENTRYPOINT ["php-fpm"]