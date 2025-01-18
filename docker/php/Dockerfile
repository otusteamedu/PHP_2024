FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    libssl-dev \
    && docker-php-ext-install zip \
    && pecl install redis \
    && docker-php-ext-enable redis

RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

COPY /docker/php/php.ini /usr/local/etc/php/conf.d/custom.ini

COPY ./code /var/www/html

EXPOSE 9000

ENTRYPOINT ["sh", "./entrypoint.sh"]
