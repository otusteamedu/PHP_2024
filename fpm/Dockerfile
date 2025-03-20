FROM php:8.2-fpm

# ставим необходимые для нормальной работы модули
RUN apt-get update && apt-get install -y \
            libpq-dev \
            libmemcached-dev \
            zip \
            libzip-dev \
            && docker-php-ext-install pgsql pdo_pgsql zip \
            && pecl install redis \
            && pecl install memcached \
            && docker-php-ext-enable redis memcached

RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /data

VOLUME /data

CMD ["composer install"]
CMD ["php-fpm"]
