FROM php:8.3.8-fpm

RUN pecl install redis && docker-php-ext-enable redis

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet --version=2.7.6

WORKDIR /app

EXPOSE 9000

CMD ["php-fpm"]