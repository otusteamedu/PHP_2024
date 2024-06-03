FROM php:8.3-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl

RUN docker-php-ext-install sockets

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


WORKDIR /data/public

CMD ["php-fpm"]
