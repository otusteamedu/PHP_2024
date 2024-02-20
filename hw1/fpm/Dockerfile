FROM php:8.3-fpm

ARG XDEBUG_REMOTE_IP
ARG MYSQL_DATABASE
ARG MYSQL_USER
ARG MYSQL_PASSWORD
ENV XDEBUG_REMOTE_IP ${XDEBUG_REMOTE_IP}
ENV MYSQL_DATABASE ${MYSQL_DATABASE}
ENV MYSQL_USER ${MYSQL_USER}
ENV MYSQL_PASSWORD ${MYSQL_PASSWORD}

RUN apt-get update  \
  && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    libmemcached-dev \
    zlib1g-dev \
    libssl-dev \
    libmcrypt-dev \
  && pecl install  \
    mcrypt-1.0.7 \
    xdebug-3.3.1 \
    memcached-3.2.0 \
    redis-6.0.2 \
  && docker-php-ext-enable  \
    mcrypt \
    xdebug \
    memcached \
    redis \
  && docker-php-ext-install -j$(nproc)  \
    iconv  \
    mbstring  \
    mysqli  \
    pdo_mysql  \
    zip \
  && echo "1" > /dev/null
# "echo "1" > /dev/null" - заморочился, что бы последняя строка, тоже оканчивалась "/", т.е., была идинтична остальным.


COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini
COPY ./zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]
