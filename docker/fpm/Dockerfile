FROM php:8.3-fpm

RUN apt update \
  && apt install -y libmemcached-dev libssl-dev libpq-dev libzip-dev zlib1g \
  && rm -rf /var/lib/apt/lists/* /var/cache/apt/archives/* \
  && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
  && docker-php-ext-install pdo_pgsql pgsql \
  && pecl install redis-5.3.7 \
  && pecl install memcached-3.2.0 \
  && docker-php-ext-enable redis memcached \
  && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf

WORKDIR /data