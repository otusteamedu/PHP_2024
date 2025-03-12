FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    libssl-dev \
    librabbitmq-dev \
    && docker-php-ext-install pdo pdo_pgsql sockets ctype iconv \
    && pecl install amqp \
    && docker-php-ext-enable amqp

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www
COPY ../../app/ /var/www
RUN composer install

CMD ["php-fpm"]