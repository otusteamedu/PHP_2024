ARG PHP_VERSION=8.3-fpm

FROM php:${PHP_VERSION}

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    libmemcached-dev \
    libssl-dev \
    libmcrypt-dev \
    && pecl install mcrypt-1.0.7 \
    && docker-php-ext-enable mcrypt \
    && docker-php-ext-install -j$(nproc) pgsql pdo pdo_pgsql opcache bcmath zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && pecl install memcached \
    && docker-php-ext-enable memcached \
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

CMD ["php-fpm"]
