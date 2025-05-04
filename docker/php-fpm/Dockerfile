FROM php:8.0-fpm

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
	      libpng-dev \
				libonig-dev \
				libzip-dev \
				zlib1g-dev \
        libssl-dev \
				libmcrypt-dev \
        libpq-dev \
        curl \
        bash \
        && pecl install mcrypt \
				&& docker-php-ext-enable mcrypt \
        && docker-php-ext-install -j$(nproc) iconv mbstring pdo pdo_pgsql pgsql zip sockets\
				&& docker-php-ext-configure gd --with-freetype \
        && docker-php-ext-install -j$(nproc) gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /var/www/app.loc

CMD ["php-fpm"]