FROM php:8.3.3-fpm

# Установка необходимых пакетов, включая locales
RUN apt-get update && apt-get install -y \
    curl \
    wget \
    git \
    locales \
    libmcrypt-dev \
    zlib1g-dev \
    libmemcached-dev \
    libssl-dev \
    && pecl install memcached \
    && docker-php-ext-enable memcached

# Настройка локали
RUN echo "ru_RU.UTF-8 UTF-8" > /etc/locale.gen && \
    locale-gen ru_RU.UTF-8 && \
    update-locale LANG=ru_RU.UTF-8

ENV LANG ru_RU.UTF-8
ENV LC_ALL ru_RU.UTF-8

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet


COPY general.ini /usr/local/etc/php/conf.d/general.ini


WORKDIR /var/www/mysite.local

CMD ["php-fpm"]