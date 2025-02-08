FROM php:8.2

RUN apt-get update && apt-get install -y \
    zip \
    libzip-dev \
    && docker-php-ext-install zip

RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

ARG SOURCE_PATH=/var/www
WORKDIR $SOURCE_PATH
COPY . $SOURCE_PATH

ENTRYPOINT ["sh", "./entrypoint.sh"]
