FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
    && docker-php-ext-install sockets

WORKDIR /var/chat-unix/entrypoint

VOLUME /var/chat-unix/entrypoint

CMD ["php-fpm"]