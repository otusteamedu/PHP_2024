ARG PHP_VERSION=8.3-fpm

FROM php:${PHP_VERSION}

RUN apt-get update && apt-get install -y \
    libzip-dev \
    && docker-php-ext-install -j$(nproc) opcache bcmath zip

COPY docker/php-fpm/php.ini $PHP_INI_DIR/conf.d/php.ini

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && php composer-setup.php --install-dir=/usr/local/bin --filename=composer

RUN usermod -u 1000 www-data

COPY --chown=www-data:www-data project/ /project/

RUN chown -R www-data:www-data /project/

WORKDIR /project

USER www-data

RUN export COMPOSER_HOME=$(pwd) && composer --no-progress --prefer-dist --no-interaction install;

CMD ["php-fpm"]
