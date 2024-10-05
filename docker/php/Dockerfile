FROM php:8.2-cli

ENV TIMEZONE Europe/Moscow

RUN apt-get update && apt-get install -y \
        curl \
        zip \
        libzip-dev \
        libonig-dev \
        unzip \
        libpq-dev

# Install PHP extensions
RUN docker-php-ext-install zip mbstring
RUN docker-php-ext-enable mbstring
RUN docker-php-ext-install pdo_pgsql

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install TimeZone
RUN cp /usr/share/zoneinfo/${TIMEZONE} /etc/localtime \
    && echo "${TIMEZONE}" > /etc/timezone
	

WORKDIR /var/www/html/

VOLUME /var/www/html/

CMD ["php", "-a"]