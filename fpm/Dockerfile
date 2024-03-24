# Собираю образ на основе fedora, так как в ней есть все модули php под arm архитектуру
FROM fedora:37

# Установка php и расширений
RUN yum install -y https://rpmfind.net/linux/fedora/linux/releases/37/Everything/aarch64/os/Packages/p/php-8.1.10-1.fc37.aarch64.rpm \
   php \
   php-bcmath \
   php-xml \
   php-pear \
   php-pgsql \
   php-gd \
   php-soap \
   php-pdo \
   php-redis \
   php-mbstring \
   php-mcrypt \
   php-soap \
   php-devel \
   php-process \
   php-zip \
   php-gmp \
   php-fpm \
   php-pecl-memcached \
   php-ast \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=bin --filename=composer \
    && php -r "unlink('composer-setup.php');" \
    && composer self-update  \
    && mkdir /data



# Глобальные настройки
COPY ./php-fpm.conf /etc/php-fpm.conf
COPY ./pool.conf /etc/php-fpm.d/www.conf

WORKDIR /data

CMD ["/usr/sbin/php-fpm", "--nodaemonize", "--force-stderr" ,"--fpm-config", "/etc/php-fpm.conf"]
