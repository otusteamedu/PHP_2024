FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
    zip \
    unzip \
    git

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    chmod +x /usr/local/bin/composer

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]