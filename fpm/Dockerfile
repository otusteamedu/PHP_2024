FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
        git \
        curl \
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
        libmagickwand-dev --no-install-recommends

# Install PHP extensions
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql

RUN docker-php-ext-install zip pdo pdo_mysql mbstring sodium exif pcntl bcmath gd pgsql pdo_pgsql gettext
RUN docker-php-ext-enable pdo pdo_mysql mbstring sodium exif pcntl bcmath gd pgsql pdo_pgsql gettext
RUN docker-php-ext-install sockets

WORKDIR /var/www/html/

VOLUME /var/www/html/

CMD ["php-fpm"]