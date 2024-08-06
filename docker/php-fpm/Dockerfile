ARG PHP_BASEIMAGE_VERSION

FROM php:${PHP_BASEIMAGE_VERSION}-fpm-alpine as base
ARG TIME_ZONE
ARG USER_ID
ARG GROUP_ID

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN apk update && \
    apk add msmtp shadow tzdata && \
    apk add composer   && \
    install-php-extensions gd intl pdo_mysql zip xml mbstring gmp sockets redis-stable memcached-stable memcache-stable && \
    cp /usr/share/zoneinfo/${TIME_ZONE} /etc/localtime && echo ${TIME_ZONE} > /etc/timezone && \
    usermod -u ${USER_ID} www-data && groupmod -g ${GROUP_ID} www-data && \
    apk del tzdata shadow && \
    rm -rf /var/cache/apk/*

RUN touch $PHP_INI_DIR/conf.d/00-base.ini && \
    echo "date.timezone=${TIME_ZONE}" >> $PHP_INI_DIR/conf.d/00-base.ini


FROM base as develop
RUN cp "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
WORKDIR /app/

FROM base as production
RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY ./app /app
WORKDIR /app/
RUN composer install --optimize-autoloader --no-dev
RUN chown -R www-data:www-data /app/


