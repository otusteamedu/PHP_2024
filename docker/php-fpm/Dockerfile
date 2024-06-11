FROM php:8.2-fpm

RUN apt-get update && apt-get install --yes \
    git \
    zip \
    unzip \
    zlib1g-dev \
    libicu-dev \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install intl opcache pdo pdo_pgsql pgsql sockets \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip
#    libicu-dev zip \
#    libzip-dev zip \

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

WORKDIR /var/www/application.local