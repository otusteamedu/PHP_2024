FROM nginx:1.25.2-alpine

COPY nginx.conf /etc/nginx/
COPY default.conf /etc/nginx/conf.d

RUN apk update && apk upgrade && apk add --no-cache bash

ARG PHP_UPSTREAM_CONTAINER
ENV PHP_UPSTREAM_CONTAINER $PHP_UPSTREAM_CONTAINER

ARG PHP_UPSTREAM_PORT
ENV PHP_UPSTREAM_PORT $PHP_UPSTREAM_PORT

RUN set -x ; \
    addgroup -g 82 -S www-data ; \
    adduser -u 82 -D -S -G www-data www-data && exit 0 ; exit 1

RUN echo "upstream php-upstream { server ${PHP_UPSTREAM_CONTAINER}:${PHP_UPSTREAM_PORT}; }" > /etc/nginx/conf.d/upstream.conf

EXPOSE 80
