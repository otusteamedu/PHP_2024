ARG PHP_VERSION=8.3-fpm

FROM php:${PHP_VERSION}

RUN apt-get update && apt-get install -y \
    && pecl install redis \
    && docker-php-ext-enable redis

COPY docker/php-fpm/php.ini $PHP_INI_DIR/conf.d/php.ini
COPY docker/php-fpm/www.conf /usr/local/etc/php-fpm.d/zz-docker.conf

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && php composer-setup.php --install-dir=/usr/local/bin --filename=composer

RUN usermod -u 1000 www-data

COPY --chown=www-data:www-data project/ /var/www/project/

RUN chown -R www-data:www-data /var/www

WORKDIR /var/www/project

USER www-data

RUN export COMPOSER_HOME=$(pwd) && composer --no-progress --prefer-dist --no-interaction install;

EXPOSE 9000

CMD ["php-fpm"]
