FROM php:8.2.20-cli

RUN apt-get update && apt-get install -y unzip

RUN pecl install redis && docker-php-ext-enable redis

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet --version=2.7.6

WORKDIR /app