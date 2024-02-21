FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
        curl \
        wget \
        nano \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && rm "$PHP_INI_DIR/php.ini-development"