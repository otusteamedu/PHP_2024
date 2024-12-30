FROM php:8.3-fpm

RUN apt-get update --fix-missing && apt-get install -y \
    zip \
    libicu-dev \
    libzip-dev \
    libssl-dev \
    libmemcached-dev \
    libmcrypt-dev \
    && docker-php-ext-install -j$(nproc) iconv mysqli pdo_mysql zip intl sockets \
     && pecl install memcached-3.2.0 && \
        docker-php-ext-enable memcached
# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

RUN usermod -u 1000 www-data

COPY --chown=www-data:www-data /directoryViewer /data/mysite.local
RUN chown -R www-data:www-data /data

WORKDIR /data

VOLUME /data

USER www-data

CMD ["php-fpm"]




