FROM php:8.3

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    libssl-dev \
    libmcrypt-dev \
    && pecl install mcrypt-1.0.7 \
    && docker-php-ext-enable mcrypt \
    && docker-php-ext-install -j$(nproc) zip sockets

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

COPY . .

RUN composer install && composer dump-autoload