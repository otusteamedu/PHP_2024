FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
      apt-utils \
      libpq-dev \
      libxslt1-dev \
      libpng-dev \
      libzip-dev \
      zip unzip \
      libmemcached11 \
      libmemcachedutil2 \
      libmemcached-dev \
      git && \
      pecl install redis && \
      pecl install memcached && \
      docker-php-ext-install pdo_mysql && \
      docker-php-ext-install bcmath && \
      docker-php-ext-install gd && \
      docker-php-ext-install zip && \
      docker-php-ext-install xsl && \
      docker-php-ext-enable redis && \
      docker-php-ext-enable memcached && \
      apt-get clean && \
      rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY ./php.ini /usr/local/etc/php/conf.d/php.ini
COPY ./zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf

ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

WORKDIR /otusphp
