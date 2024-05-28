FROM php:8.3.2-fpm

RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libmemcached-dev \
    libssl-dev \
    git \
    unzip

RUN docker-php-ext-install pdo pdo_mysql sockets && docker-php-ext-enable pdo pdo_mysql sockets

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet --version=2.6.6

WORKDIR /app

EXPOSE 9000

CMD ["php-fpm"]
