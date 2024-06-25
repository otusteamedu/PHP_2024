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

RUN docker-php-ext-install sockets
RUN docker-php-ext-enable sockets

#composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini
COPY ./zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf

WORKDIR /www/public_html

ENTRYPOINT [ "php-fpm" ]