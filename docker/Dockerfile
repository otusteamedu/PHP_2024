FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git \
    libpq-dev\
    unzip \

RUN docker-php-ext-install pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install

CMD ["php", "/app/app.php"]
