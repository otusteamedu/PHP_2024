FROM php:8.3.2-fpm

RUN apt-get update && apt-get install zip unzip

RUN docker-php-ext-install pdo pdo_mysql  && docker-php-ext-enable pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /data/public

CMD ["php-fpm"]
