FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
        curl \
        wget \
        git \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libonig-dev \
        libzip-dev \
        libpq-dev \
        libmcrypt-dev \
        && pecl install mcrypt-1.0.7 \
        && pecl install redis \
        && docker-php-ext-enable mcrypt \
        && docker-php-ext-install -j$(nproc) iconv mbstring pdo_pgsql pgsql zip \
        && docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd \
        && curl -s https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer && composer self-update

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]