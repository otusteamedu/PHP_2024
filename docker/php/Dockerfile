FROM php:8.1-fpm-alpine

# Install dev dependencies
RUN apk update \
    && apk upgrade --available \
    && apk add --virtual build-deps \
        autoconf \
        build-base \
        icu-dev \
        openssl-dev \
        zlib-dev \
        libzip \
        libzip-dev \
        zlib \
        zlib-dev \
        bzip2 \
        git \
        libpng \
        libpng-dev \
        libjpeg \
        libjpeg-turbo-dev \
        libwebp-dev \
        linux-headers \
        freetype \
        freetype-dev \
        postgresql-dev \
        curl \
        wget \
        bash \
        mysql mysql-client

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/
RUN docker-php-ext-install -j$(getconf _NPROCESSORS_ONLN) \
    intl \
    gd \
    bcmath \
    pcntl \
    pdo_pgsql \
    sockets \
    zip \
    mysqli pdo pdo_mysql \
    pdo_mysql



COPY --chown=www-data:www-data ./ /data/mysite.local
RUN chown -R www-data:www-data /data/mysite.local

WORKDIR /data

VOLUME /data

USER www-data

CMD ["php-fpm"]

