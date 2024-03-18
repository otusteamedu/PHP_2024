FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
	libfreetype6-dev \
	libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
	libmemcached-dev \
	zlib1g-dev \
	libssl-dev \
	libmcrypt-dev \
	&& pecl install -o -f redis \
  	&& docker-php-ext-enable redis \
	&& pecl install -o -f memcached \
	&& docker-php-ext-enable memcached \
	&& pecl install mcrypt-1.0.6 \
	&& docker-php-ext-enable mcrypt \
	&& docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
	&& docker-php-ext-install -j$(nproc) gd

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /var/www/html/otus-edu.localhost

VOLUME /data

CMD ["php-fpm"]
