FROM php:8.2-fpm

WORKDIR /app

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install sockets pdo_pgsql
# ставим необходимые для нормальной работы модули
# RUN pecl install redis && docker-php-ext-enable redis

#загружаем composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    chmod +x /usr/local/bin/composer

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

CMD ["php-fpm"]

