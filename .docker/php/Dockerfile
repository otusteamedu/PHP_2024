FROM php:7.4-fpm
LABEL maintainer="Dmitrii Grishin"
RUN apt-get update && apt-get install -y zlib1g-dev libzip-dev zip libpq-dev libfreetype6-dev libjpeg62-turbo-dev libpng-dev libonig-dev libmemcached-dev libpq-dev \
        && pecl install redis memcached \
	    && docker-php-ext-enable memcached redis \
        && docker-php-ext-install -j$(nproc) iconv mysqli pdo_mysql zip mbstring \
        && docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd 
        
COPY /.docker/php/php.ini /usr/local/etc/php/conf.d/php-custom.ini

VOLUME /srv/code/
WORKDIR /srv/code/

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
RUN chown -R www-data:www-data /srv/code