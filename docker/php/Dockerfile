FROM php:8.2-fpm

WORKDIR /data

RUN apt-get update && apt-get install -y

# ставим необходимые для нормальной работы модули
RUN pecl install redis && docker-php-ext-enable redis

#загружаем composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    chmod +x /usr/local/bin/composer

# RUN composer install

CMD ["php-fpm"]
