FROM php:7.4-fpm

# установка модулей
RUN apt-get update && apt-get install -y \
        curl \
        wget \
        git \
        libonig-dev \
        libzip-dev \
        libxml2-dev \
		libfreetype-dev \
		libjpeg62-turbo-dev \
		libpng-dev \
        && pecl install redis-5.3.7 \
    	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
    	&& docker-php-ext-install -j$(nproc) gd \
        && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip xml \
        && docker-php-ext-enable iconv mbstring mysqli pdo_mysql zip xml

# установка composer
RUN curl -sS https://getcomposer.org/installer \
      | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /data

CMD ["php-fpm"]