FROM php:7.4-fpm
RUN apt-get update && apt-get install -y \
apt-utils \
curl \
wget \
libfreetype6-dev \
libjpeg62-turbo-dev \
libmemcached-dev \
libsasl2-dev \
zlib1g-dev \
libpng-dev \
libonig-dev \
libzip-dev \
libmcrypt-dev \
&& pecl install mcrypt-1.0.3 xdebug-2.9.6 redis memcached \
&& docker-php-ext-enable mcrypt xdebug redis memcached \
&& docker-php-ext-install -j$(nproc) iconv mbstring zip \
&& docker-php-ext-configure gd --with-freetype --with-jpeg \
&& docker-php-ext-install -j$(nproc) gd
RUN apt-get install unixodbc unixodbc-dev -y \
&& docker-php-ext-configure pdo_odbc --with-pdo-odbc=unixODBC,/usr \
&& docker-php-ext-install pdo_odbc pdo_mysql mysqli
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ADD php.ini /usr/local/etc/php/conf.d/40-custom.ini
WORKDIR /usr/bin
ADD ["entrypoint.sh", "./"]
RUN chmod +x entrypoint.sh
RUN mkdir -p /var/run/php
RUN sed -i 's/listen = 9000/listen = \/var\/run\/php\/php7.4-fpm.sock/' /usr/local/etc/php-fpm.d/zz-docker.conf
ENTRYPOINT ["entrypoint.sh"]