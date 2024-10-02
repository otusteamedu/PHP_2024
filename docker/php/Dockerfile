FROM php:8.2-fpm

RUN apt-get update && apt-get install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip -y libpq-dev curl \
        && apt-get update && apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev libonig-dev libzip-dev libmemcached-dev libmcrypt-dev \
        && docker-php-ext-install pdo pdo_pgsql pgsql \
        && pecl install apcu \
        && pecl install redis \
        && docker-php-ext-enable apcu \
        && docker-php-ext-configure zip \
        && docker-php-ext-install zip \
        && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd \
        && docker-php-ext-install sockets \
        && pecl install memcached && \
        docker-php-ext-enable memcached \
        curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
        pecl install -o -f redis \
        &&  rm -rf /tmp/pear \
        &&  echo "extension=redis.so" > /usr/local/etc/php/conf.d/redis.ini

COPY --from=composer /usr/bin/composer /usr/local/bin/composer

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]
