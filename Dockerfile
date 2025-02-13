FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    libpq-dev \
    libicu-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install \
    zip \
    intl \
    pdo_pgsql \
    mbstring \
    opcache \
    xml

RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

ARG SOURCE_PATH=/var/www
WORKDIR $SOURCE_PATH
COPY . .

EXPOSE 9000

ENTRYPOINT ["sh", "./entrypoint.sh"]
