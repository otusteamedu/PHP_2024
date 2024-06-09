FROM php:8.3.8-fpm

RUN docker-php-ext-install pdo pdo_mysql  && docker-php-ext-enable pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet --version=2.7.6

RUN mkdir /elasticsearch

WORKDIR /app

EXPOSE 9000

CMD ["php-fpm"]