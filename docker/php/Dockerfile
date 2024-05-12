FROM php:8.3.2-fpm

RUN apt-get update && apt-get install -y \
		&& docker-php-ext-install pdo pdo_mysql \
    && curl -sS https://getcomposer.org/installer -o composer-setup.php \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer

WORKDIR /data

CMD ["php-fpm"]
