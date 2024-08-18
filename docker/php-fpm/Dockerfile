FROM php:8.2-fpm

RUN apt update \
  && apt install -y zip libssl-dev libpq-dev libzip-dev zlib1g \
  && rm -rf /var/lib/apt/lists/* /var/cache/apt/archives/* \
  && docker-php-ext-install zip \
  && pecl install redis-5.3.7 \
  && docker-php-ext-enable redis \
  && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /data