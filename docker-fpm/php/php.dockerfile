FROM php:8.1-fpm

# common
RUN apt-get update
RUN apt-get install -y curl git vim

#mysql
RUN docker-php-ext-install pdo pdo_mysql

#memcache
RUN apt-get install -y zlib1g-dev
RUN pecl install memcache
RUN docker-php-ext-enable memcache

#redis
RUN pecl install redis
RUN docker-php-ext-enable redis

#composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /www/public_html

ENTRYPOINT [ "php-fpm" ]