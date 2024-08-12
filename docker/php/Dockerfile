FROM php:8.2-fpm

WORKDIR /var/www/app

RUN apt-get update && apt-get install -y zlib1g-dev librabbitmq-dev libssl-dev g++ git libicu-dev zip libzip-dev libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install intl opcache bcmath sockets pdo pdo_pgsql pgsql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && pecl install amqp && docker-php-ext-enable amqp \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apt-get clean && rm -rf /var/lib/apt/lists/*