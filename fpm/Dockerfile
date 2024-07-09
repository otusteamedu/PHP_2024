FROM php:8.3-fpm

ENV TIMEZONE Europe/Moscow

RUN apt-get update
RUN apt-get install -y \
		libfreetype-dev \
		libjpeg62-turbo-dev \
		libpng-dev

RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) gd

RUN apt-get update && apt-get install -y \
        curl \
        wget \
        git \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        libjpeg-dev \
        libxpm-dev \
        libwebp-dev \
        libmcrypt-dev \
        zlib1g-dev \
        zip \
        unzip \
        libpq-dev \
        libzip-dev \
        libsodium-dev \
        libmagickwand-dev --no-install-recommends \
        libmemcached-dev

# Install PHP extensions
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql

# xdebug
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug
RUN echo "xdebug.mode=client_port = 9000" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo echo "xdebug.client_host = host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo echo "xdebug.start_with_request = yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo echo "xdebug.output_dir = /tmp/grinds" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN pecl install redis \
    && docker-php-ext-enable redis

RUN pecl install memcached
RUN echo extension=memcached.so >> /usr/local/etc/php/conf.d/memcached.ini

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install zip pdo pdo_mysql mbstring sodium exif pcntl bcmath pgsql pdo_pgsql gettext
RUN docker-php-ext-enable pdo pdo_mysql mbstring sodium exif pcntl bcmath gd pgsql pdo_pgsql gettext

RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install TimeZone
RUN cp /usr/share/zoneinfo/${TIMEZONE} /etc/localtime \
    && echo "${TIMEZONE}" > /etc/timezone

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]
