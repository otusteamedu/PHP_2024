FROM php:8.2-cli

WORKDIR /data

COPY ./composer.json /data/composer.json

RUN docker-php-ext-install sockets && docker-php-ext-enable sockets
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install && composer dump-autoload