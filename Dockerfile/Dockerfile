FROM php:8.2-cli

# Установка Redis-расширения для PHP
RUN docker-php-ext-install sockets \
    && pecl install redis \
    && docker-php-ext-enable redis

# Установка рабочего каталога
WORKDIR /var/www/html

# Копируем приложение
COPY . .

