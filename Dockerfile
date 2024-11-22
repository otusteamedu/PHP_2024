FROM php:cli

# Установка PostgreSQL драйвера для PDO
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql

WORKDIR /var/www/html
