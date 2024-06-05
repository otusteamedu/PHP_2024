FROM php:8.2-fpm

WORKDIR /app

EXPOSE 9000

RUN docker-php-ext-install pdo mysqli pdo_mysql
RUN apt-get update && apt-get install -y libmemcached-dev libssl-dev zlib1g-dev
RUN pecl install redis && pecl install memcached && docker-php-ext-enable memcached redis

VOLUME /app

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

CMD ["php-fpm"]

