FROM php:8.2-fpm

RUN pecl install redis && docker-php-ext-enable redis
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet --version=2.6.6

COPY redis.ini /usr/local/etc/php/conf.d/redis.ini

WORKDIR /code

USER root

CMD ["php-fpm"]
