FROM php:7.0-fpm-alpine

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    chmod +x /usr/local/bin/composer

WORKDIR /data

COPY ./index.php /data/index.php
COPY ./composer.json /data/composer.json

RUN composer install

CMD ["php-fpm"]