FROM php:8.2-cli

RUN docker-php-ext-install sockets

WORKDIR /var/www/app

CMD [ "php", "app.php", "server" ]