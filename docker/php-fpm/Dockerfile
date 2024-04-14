ARG PHP_VERSION=8.3-fpm

FROM php:${PHP_VERSION}

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    && docker-php-ext-install -j$(nproc) pgsql pdo pdo_pgsql opcache bcmath zip

COPY docker/php-fpm/php.ini $PHP_INI_DIR/conf.d/php.ini
COPY docker/php-fpm/www.conf /usr/local/etc/php-fpm.d/zz-docker.conf

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && php composer-setup.php --install-dir=/usr/local/bin --filename=composer

RUN usermod -u 1000 www-data

COPY --chown=www-data:www-data mm-service/ /var/www/mm-service/

RUN chown -R www-data:www-data /var/www

WORKDIR /var/www/mm-service

USER www-data

CMD ["php-fpm"]
