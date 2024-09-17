FROM php:8.3.2-fpm

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet --version=2.6.6

# install xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug
ADD conf.d/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

WORKDIR /app

EXPOSE 9000

CMD ["php-fpm"]