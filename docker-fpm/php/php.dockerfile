FROM php:8.1-fpm

# common
RUN apt-get update
RUN apt-get install -y curl git vim

#mysql
RUN docker-php-ext-install pdo pdo_mysql

#composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /www/public_html

ENTRYPOINT [ "php-fpm" ]