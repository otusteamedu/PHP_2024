FROM php:8.3-cli

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer self-update

WORKDIR /data

VOLUME /data

CMD ["ping", "ya.ru;"]