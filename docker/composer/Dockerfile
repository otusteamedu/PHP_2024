FROM composer:latest

WORKDIR /data/application.local

COPY ./composer.json /data/application.local

COPY ./composer.lock /data/application.local

RUN composer install

RUN composer require ilya-plotnikov/hello-name
