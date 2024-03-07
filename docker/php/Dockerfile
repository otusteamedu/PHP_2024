FROM php:7.0-fpm-alpine

RUN apk add --no-cache \
    zip \
    unzip \
    git

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    chmod +x /usr/local/bin/composer

WORKDIR /data

CMD ["php-fpm"]