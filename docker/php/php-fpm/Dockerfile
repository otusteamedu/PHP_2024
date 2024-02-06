FROM php:8.3-fpm

RUN apt-get update && apt-get install -y zlib1g-dev libzip-dev zip libpq-dev libfreetype6-dev libjpeg62-turbo-dev libpng-dev libonig-dev libmemcached-dev libpq-dev \
  && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
  && docker-php-ext-install pdo_pgsql zip gd pgsql pdo_pgsql \
  && pecl install memcached redis \
  && docker-php-ext-enable memcached redis \
  && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql

COPY ../conf.d/php.ini /usr/local/etc/php/conf.d/php-custom.ini
COPY ../php-fpm/zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf

WORKDIR /app/mysite.local

VOLUME /app

CMD ["php-fpm"]
