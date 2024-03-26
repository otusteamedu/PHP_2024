FROM php:8.2-fpm

RUN pecl install redis && docker-php-ext-enable redis

COPY redis.ini /usr/local/etc/php/conf.d/redis.ini

CMD ["php-fpm"]
