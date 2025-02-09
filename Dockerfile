FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    libpq-dev \
    && docker-php-ext-install pgsql pdo_pgsql zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ARG SOURCE_PATH=/var/www
WORKDIR $SOURCE_PATH
COPY . $SOURCE_PATH
RUN composer install --no-dev --optimize-autoloader

CMD ["php", "-S", "0.0.0.0:8000"]
