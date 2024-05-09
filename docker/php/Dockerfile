FROM php:cli

RUN apt-get update && apt-get install -y zip unzip git curl wget

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    chmod +x /usr/local/bin/composer

WORKDIR /data