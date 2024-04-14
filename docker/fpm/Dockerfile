FROM php:8.2-fpm
RUN apt-get update && apt-get install -y \
		libfreetype-dev \
        libonig-dev \
        libzip-dev \
        libmemcached-dev \
        libssl-dev \
        && pecl install redis \
        && docker-php-ext-enable redis \
        && curl -sS https://getcomposer.org/installer -o composer-setup.php \
        && php composer-setup.php --install-dir=/usr/local/bin --filename=composer

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /data

CMD ["php-fpm"]