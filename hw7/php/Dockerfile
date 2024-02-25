FROM php:8.3-cli

ARG XDEBUG_REMOTE_IP
ENV XDEBUG_REMOTE_IP ${XDEBUG_REMOTE_IP}

RUN apt-get update  \
  && apt-get install -y \
    libonig-dev \
    libzip-dev \
  && pecl install  \
    xdebug-3.3.1 \
  && docker-php-ext-enable  \
    xdebug \
  && docker-php-ext-install -j$(nproc)  \
    mbstring  \
    zip \
  && echo "1" > /dev/null
# echo "1" > /dev/null" - заморочился, что бы последняя строка, тоже оканчивалась "/", т.е., была идинтична остальным.


COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

WORKDIR /data/code_root

CMD tail -f /dev/null

