FROM php:8.3-fpm

ARG PUID=1000
ARG PGID=1000

RUN apt-get update && apt-get install -y \
    supervisor bash libpq-dev librabbitmq-dev autoconf make zlib1g-dev libzip-dev unzip \
    && pecl install amqp \
    && docker-php-ext-install pdo_pgsql zip \
    && docker-php-ext-enable amqp zip \
    && groupmod -g ${PGID} www-data \
    && usermod -u ${PUID} -g www-data www-data \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY ./zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf
COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

COPY supervisord.conf /etc/supervisor/supervisord.conf
COPY messenger-worker.conf /etc/supervisor/conf.d/messenger-worker.conf

WORKDIR /var/www

EXPOSE 9000

CMD ["sh", "-c", "php-fpm -D && exec /usr/bin/supervisord -c /etc/supervisor/supervisord.conf"]
