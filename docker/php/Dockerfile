FROM php:8.0-fpm

RUN apt-get update && apt-get install -y \
        libmemcached-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libwebp-dev \
        curl \
        git \
        zip unzip libzip-dev \
    && pecl install  \
        memcached \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j "$(nproc)" gd mysqli pdo pdo_mysql zip opcache \
    && docker-php-ext-enable mysqli pdo pdo_mysql memcached



RUN pecl channel-update pecl.php.net
RUN pecl install redis && docker-php-ext-enable redis

# Install Composer
#RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
#&& composer --version

# remove not necessary files
RUN rm -rf /var/lib/apt/lists/*

CMD ["php-fpm"]
