FROM php:8.3-cli

ARG CONTAINER_TYPE

RUN apt-get update && apt-get install -y libedit-dev \
  && docker-php-ext-install sockets

COPY ../conf.d/php.ini /usr/local/etc/php/conf.d/php-custom.ini

RUN if [ "${CONTAINER_TYPE}" = "server" ]; then \
  curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet; \
  fi

ENV COMPOSER_ALLOW_SUPERUSER 1

WORKDIR /app
