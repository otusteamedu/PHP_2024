FROM php:8.2-fpm
RUN apt-get update && apt-get install -y \
    curl \
    zlib1g-dev \
    libzip-dev \
    libmemcached-dev \
    libssl-dev \
    && docker-php-ext-install -j$(nproc) mysqli pdo pdo_mysql \
    zip

#Установка memcached
RUN pecl install memcached && docker-php-ext-enable memcached

#Установка SSH-клиента, чтобы подключаться к контейнерам во внутренней сети
RUN apt-get install -y ssh

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# Альтернативный вариант (копирование из оффициального образа)
#COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

#Установка xDebug + .ini: zend_extension=xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host = host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.idekey = PHPSTORM" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

WORKDIR /data

ENTRYPOINT ["php-fpm"]