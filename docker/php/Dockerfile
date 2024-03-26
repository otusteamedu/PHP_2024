FROM php:8.0-fpm

# Install modules
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libicu-dev \
        libmcrypt-dev \
        libbz2-dev \
        libc-client-dev \
        libxslt-dev \
        libkrb5-dev \
        libgraphicsmagick1-dev \
        libjpeg-dev \
        net-tools \
        iproute2 \
        libcurl3-dev \
        git \
        libonig-dev \
        libmcrypt-dev \
        libmemcached-dev \
        --no-install-recommends

#Install PECL modules
RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install bz2 calendar imap pcntl shmop sockets sysvmsg sysvsem sysvshm intl mbstring pdo_mysql mysqli gettext exif

# install redis
RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet --version=2.1.3

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

COPY ./conf.d /usr/local/etc/php/conf.d

WORKDIR /app
