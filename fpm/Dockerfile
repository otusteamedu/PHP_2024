FROM php:8.3-fpm

RUN apt-get update
RUN apt-get install -y \
    curl \
    wget \
#ПО для отрисовки шрифтов
    libfreetype6-dev \
#кодек изображений JPEG для ускорения сжатия и распаковки JPEG на системах x86, x86- 64
    libjpeg62-turbo-dev \
    libpng-dev \
# \с регулярными выражениями
#    libonig-dev \
# library for reading, creating, and modifying zip archives
    libzip-dev \
#    libmcrypt-dev \
# библиотека сжатия
#    zlib1g-dev \
#    libssl-dev \
    libmemcached-dev

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions xdebug-3.3.1 memcached-3.2.0 mcrypt-1.0.7 redis-6.0.2

#RUN yes '' | pecl install -f memcached-3.2.0
#RUN docker-php-ext-enable memcached
#RUN pecl install mcrypt-1.0.7
#RUN docker-php-ext-enable mcrypt
#RUN pecl install xdebug-3.3.1
#RUN docker-php-ext-enable xdebug
#RUN pecl install redis-6.0.2
#RUN docker-php-ext-enable redis

# -j$(nproc) - флаг для того, чтобы использовать максимально возможное количество jobs
RUN docker-php-ext-install -j$(nproc) \
#    iconv \
#    mbstring \
    mysqli \
    pdo_mysql \
    zip
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /data

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

VOLUME /data

CMD ["php-fpm"]
