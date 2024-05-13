FROM php:8.2-cli

RUN docker-php-ext-install sockets pcntl

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /data

VOLUME /data

CMD composer install && php app.php client
