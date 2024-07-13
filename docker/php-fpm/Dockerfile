FROM php:8.2-fpm

EXPOSE 9000

RUN apt-get update && apt-get install -y \
    curl \
    wget \
    git \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
	libmcrypt-dev \
	libmemcached-dev \
	zlib1g-dev \
	libssl-dev \
	libpq-dev \
    && docker-php-ext-install -j$(nproc) iconv mbstring pdo pdo_pgsql pgsql mysqli pdo_mysql zip \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install sockets && docker-php-ext-enable sockets \
#    && pecl install redis && docker-php-ext-enable redis \
    && pecl install xdebug && docker-php-ext-enable xdebug \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Create system user to run Composer and Artisan Commands
#RUN useradd -G www-data,root -u $uid -d /home/$user $user
#RUN mkdir -p /home/$user/.composer && chown -R $user:$user /home/$user

# Set working directory
WORKDIR /app/public

#USER $user

COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY ./php.ini /usr/local/etc/php/conf.d/php.ini
#COPY ./composer.json /data/composer.json
#
#RUN composer install && composer dump-autoload

CMD ["php-fpm"]