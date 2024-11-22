FROM php:8.2-fpm

WORKDIR /data

RUN apt-get update && apt-get install -y \
    libzip-dev \
    && docker-php-ext-install -j$(nproc) zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer self-update

CMD ["php-fpm"]