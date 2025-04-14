FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
        curl \
        wget \
        git \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libonig-dev \
        libzip-dev \
        libmcrypt-dev \
        libpq-dev \
		zlib1g-dev \
		libzip-dev \
		unzip\
    && pecl install mcrypt-1.0.3 \
	&& docker-php-ext-enable mcrypt \
	&& docker-php-ext-install zip \
	&& docker-php-ext-install sockets\
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo pdo_pgsql pgsql zip \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /data/mysite.local

VOLUME /data/mysite.local

CMD ["php-fpm"]