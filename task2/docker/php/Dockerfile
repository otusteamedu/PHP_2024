FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    curl \
    wget \
    nano \
    sudo \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && rm "$PHP_INI_DIR/php.ini-development"

RUN pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis \
    && apt install -y libmemcached-dev zlib1g-dev libssl-dev \
    && pecl install -f memcached-3.2.0 \
    && docker-php-ext-enable memcached

CMD ["php-fpm"]