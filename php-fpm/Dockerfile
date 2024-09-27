FROM php:8.3.2-fpm

RUN docker-php-ext-install sockets && docker-php-ext-enable sockets

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet --version=2.6.6

WORKDIR /app

EXPOSE 9000

CMD ["php-fpm"]
