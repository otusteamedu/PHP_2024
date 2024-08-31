# syntax=docker/dockerfile:1.4
FROM php:8.3-fpm-alpine AS php

ARG APPLICATION_SOURCE_DIR="./app"
ARG APPLICATION_CONTAINER_DIR="/data/app"
ARG PHP_CONFIG_PATH="./deploy/php/conf.d/production.ini"
ENV COMPOSER_HOME="/tmp/composer"

RUN  --mount=type=bind,from=mlocati/php-extension-installer:latest,source=/usr/bin/install-php-extensions,target=/usr/local/bin/install-php-extensions \
     install-php-extensions memcache redis pdo_pgsql \
     && apk del --no-cache  ${PHPIZE_DEPS} ${BUILD_DEPENDS}

COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

RUN mkdir -p ${APPLICATION_CONTAINER_DIR}  \
    && chown www-data:www-data ${APPLICATION_CONTAINER_DIR}

FROM php AS app
USER www-data
WORKDIR ${APPLICATION_CONTAINER_DIR}

COPY --chown=www-data:www-data ${APPLICATION_SOURCE_DIR}/composer.* .
RUN composer install --no-cache --no-ansi --no-autoloader --no-scripts --no-dev

COPY --chown=www-data:www-data ${APPLICATION_SOURCE_DIR} .

RUN composer dump-autoload -n --optimize

FROM app AS develop

USER root
RUN  --mount=type=bind,from=mlocati/php-extension-installer:latest,source=/usr/bin/install-php-extensions,target=/usr/local/bin/install-php-extensions \
     install-php-extensions xdebug \
     && apk del --no-cache  ${PHPIZE_DEPS} ${BUILD_DEPENDS}

COPY ${PHP_CONFIG_PATH} /usr/local/etc/php/conf.d/

FROM app AS production

USER root
COPY ${PHP_CONFIG_PATH} /usr/local/etc/php/conf.d/
