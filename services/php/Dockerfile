FROM php:8.2-cli

RUN docker-php-ext-install sockets

WORKDIR /usr/src/chat

VOLUME /usr/src/chat

CMD ["php","./app.php","client"]