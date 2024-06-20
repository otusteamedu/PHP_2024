FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libzip-dev \
    && docker-php-ext-install zip sockets

RUN chown -R www-data:www-data /var/www/html

WORKDIR /var/www/html

CMD ["php-fpm"]