FROM php:8.3.2-fpm

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /data/public

CMD ["php-fpm"]
