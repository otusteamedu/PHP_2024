FROM php:8.2-fpm

RUN apt-get update

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet --version=2.1.3
RUN apt-get install libzip-dev zip libicu-dev libpq-dev -y
RUN docker-php-ext-install zip && docker-php-ext-configure intl && docker-php-ext-install intl
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && docker-php-ext-install pdo_pgsql pgsql

WORKDIR /app

EXPOSE 9000

CMD ["php-fpm"]