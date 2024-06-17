FROM php:7.4-fpm

RUN apt-get update && apt-get install -y curl git \
        docker-php-ext-install pdo pdo_mysql \
        curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/public_html

ENTRYPOINT [ "php-fpm" ]