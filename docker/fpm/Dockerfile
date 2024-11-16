FROM php:8.1-fpm

ENV TIMEZONE Europe/Moscow

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

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer global require "squizlabs/php_codesniffer=*"
# Configure the PATH
RUN echo 'export PATH="$PATH:$HOME/.composer/vendor/bin"' >> $HOME/.bashrc

# Install TimeZone
RUN cp /usr/share/zoneinfo/${TIMEZONE} /etc/localtime \
    && echo "${TIMEZONE}" > /etc/timezone

WORKDIR /var/www/html/

VOLUME /var/www/html/

CMD ["php-fpm"]