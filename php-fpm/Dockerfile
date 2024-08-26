FROM php:8.3

RUN apt update  \
    && apt install -y zip \
    && docker-php-ext-install sockets \
    && docker-php-ext-enable sockets \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer  \
    && rm -rf /var/lib/apt/lists/* /var/cache/apt/archives/*

WORKDIR /data/src

CMD ["php"]