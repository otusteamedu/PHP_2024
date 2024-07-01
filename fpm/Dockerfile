FROM php:8.2-fpm

# ставим необходимые для нормальной работы модули
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
        && docker-php-ext-install -j$(nproc) iconv mbstring zip \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd \
        && docker-php-ext-install sockets
RUN apt-get update && apt-get install -y libssl-dev zlib1g-dev

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]
