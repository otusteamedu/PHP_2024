FROM php:8.3.7-fpm-bullseye
LABEL authors="Viktor Rikhert"

RUN apt-get update && apt-get install -y \
        curl \
        wget \
        git \
        zlib1g-dev  \
        libssl-dev \
        libpq-dev \
        unzip \
    && pecl install xdebug-3.3.2 \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install sockets  \
    && docker-php-ext-enable sockets \
    && docker-php-ext-install -j$(nproc) pdo_pgsql \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && mkdir  -p "/var/run/php"

COPY zz-docker.conf /usr/local/etc/php-fpm.d

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]