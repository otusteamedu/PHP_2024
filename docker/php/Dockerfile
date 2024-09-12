FROM php:8.3.2-fpm

RUN docker-php-ext-install sockets && docker-php-ext-enable sockets

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /data/public

CMD ["php-fpm"]
