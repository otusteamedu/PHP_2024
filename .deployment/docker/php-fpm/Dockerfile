FROM php:8.2-fpm-alpine

RUN apk add --no-cache --update curl git build-base zlib-dev oniguruma-dev autoconf linux-headers bash libmemcached-dev libzip-dev
# Добавляем расширения для Redis и Memcached
RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && pecl install redis \
    && pecl install memcached \
    && docker-php-ext-enable redis memcached \
    && apk del -f .build-deps

# Добавление настроек Redis в php.ini
RUN echo "session.save_handler = redis" >> /usr/local/etc/php/conf.d/redis-sessions.ini && \
    echo "session.save_path = \"tcp://redis2:6379\"" >> /usr/local/etc/php/conf.d/redis-sessions.ini
# Если аргумент INSTALL_XDEBUG будет равен true, то устанавливаем xdebug (теперь можно исп. этот файл и для прод. деплоя)
ARG INSTALL_XDEBUG=false
# Подтягиваем зависимости для xdebug и включаем расширение xdebug в php.ini
RUN if [ ${INSTALL_XDEBUG} = true ];  \
    then \
      pecl install xdebug && docker-php-ext-enable xdebug; \
    fi;

# Пробрасываем xdebug.ini в контейнер php
COPY ./.deployment/docker/php-fpm/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Postgres
RUN apk add --no-cache libpq-dev \
    && docker-php-ext-install pdo_pgsql

## Configure non-root user
ARG PUID
ENV PUID $PUID

ARG PGID
ENV PGID $PGID

RUN apk --no-cache add shadow && \
    groupmod -o -g ${PGID} www-data && \
    usermod -o -u ${PUID} -g www-data www-data

# Source project
RUN mkdir /var/www/homework \
    && chown www-data:www-data /var/www/homework
COPY --chown=www-data:www-data ./ /var/www/homework
WORKDIR /var/www/homework

USER www-data

# Composer instalation
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

CMD php-fpm

EXPOSE 9000
