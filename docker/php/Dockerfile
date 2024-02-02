FROM php:8.0.11-fpm

# Install modules
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libicu-dev \
        libxml++2.6-dev \
        libmcrypt-dev \
        libbz2-dev \
        libc-client-dev \
        libxslt-dev \
        libkrb5-dev \
        libgraphicsmagick1-dev \
        libjpeg-dev \
        subversion \
        wget \
        net-tools \
        iproute2 \
        libcurl3-dev \
        git \
        libzip-dev \
        zip \
        libonig-dev \
        libmcrypt-dev \
        libmemcached-dev \
        --no-install-recommends

#Install PECL modules
RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install bz2 calendar imap pcntl shmop sockets sysvmsg sysvsem sysvshm xsl zip intl mbstring pdo_mysql mysqli opcache gettext xml exif \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

RUN pecl install mcrypt-1.0.4 igbinary-3.2.3 msgpack-2.1.2 \
    xmlrpc-1.0.0RC2

RUN echo "extension=mcrypt.so" >> /usr/local/etc/php/php.ini
RUN echo "extension=xmlrpc.so" >> /usr/local/etc/php/php.ini
RUN echo "extension=igbinary.so" >> /usr/local/etc/php/php.ini
RUN echo "extension=msgpack.so" >> /usr/local/etc/php/php.ini

RUN docker-php-ext-enable mcrypt xmlrpc igbinary msgpack

#Install memcached
RUN pecl install memcached-3.1.5 && docker-php-ext-enable memcached

#Install apcu
ARG APCU_VERSION=5.1.20
RUN pecl install apcu-${APCU_VERSION} && docker-php-ext-enable apcu
RUN echo "apc.enable_cli=1" >> /usr/local/etc/php/php.ini
RUN echo "apc.enable=1" >> /usr/local/etc/php/php.ini

# install gmagick
RUN pecl install gmagick-2.0.6RC1 \
    && docker-php-ext-enable gmagick \
    && rm -rf /tmp/pear

# install redis
RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

# clear
RUN apt-get purge -y g++ \
    && apt-get autoremove -y \
    && rm -r /var/lib/apt/lists/* \
    && rm -rf /tmp/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet --version=2.1.3


RUN mkdir /tmp/local-php-security-checker-tmp && cd /tmp/local-php-security-checker-tmp \
    && wget https://github.com/fabpot/local-php-security-checker/releases/download/v1.0.0/local-php-security-checker_1.0.0_linux_amd64 \
    && cp local-php-security-checker_1.0.0_linux_amd64 /usr/local/bin/local-php-security-checker && chmod 775 /usr/local/bin/local-php-security-checker \
    && rm -rf /tmp/local-php-security-checker-tmp

RUN usermod -u 1000 www-data

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

COPY ./www.conf /usr/local/etc/php/
COPY ./conf.d /usr/local/etc/php/conf.d

# install additional packages
RUN apt-get update && apt-get -y install cron procps iputils-ping ssh nano
WORKDIR /app

COPY ./entrypoint.sh /usr/local/bin/docker-php-entrypoint
RUN chmod +x /usr/local/bin/docker-php-entrypoint
