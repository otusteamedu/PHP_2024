FROM php:8.0-cli-alpine

RUN apk add --no-cache bash && \
    docker-php-ext-install pdo pdo_mysql

WORKDIR /root

COPY . /root

VOLUME .:/root