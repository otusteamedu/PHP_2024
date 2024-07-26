FROM php:8.3.2-fpm

WORKDIR /data

RUN apt-get update && apt-get -y install --fix-missing git \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && docker-php-ext-install sockets && docker-php-ext-enable sockets
    #&& composer create-project kyberlox/composer_chat:dev-master

WORKDIR /data/composer_chat

CMD ["php app.php server"]
#нужно зайтив конетейнер и запустить php app