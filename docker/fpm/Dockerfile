FROM php:8.3.2-fpm


RUN apt-get update && apt-get install -y \
    curl \
    wget \
    git \
    libmcrypt-dev \
    zlib1g-dev \
    libssl-dev

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet



WORKDIR /var/www/mysite.local

CMD ["php-fpm"]
