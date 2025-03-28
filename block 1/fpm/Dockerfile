FROM php:fpm

# ставим необходимые для нормальной работы модули
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
	libmemcached-dev \
	libmcrypt-dev \
        icu-devtools \
        libicu-dev \
        libpq-dev \
        && pecl install mcrypt-1.0.7 \
        && pecl install redis \
	&& pecl install memcached \
        && docker-php-ext-configure intl --enable-intl \
        && docker-php-ext-install pdo \
            pgsql pdo_pgsql \
            intl iconv mbstring \
            zip pcntl \
            exif opcache \
        && docker-php-ext-install sockets \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd \
        && docker-php-ext-enable mcrypt \
        && docker-php-ext-enable redis \
        && docker-php-ext-enable memcached

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

COPY ./php-fpm.d /usr/local/etc/php-fpm.d/

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]
