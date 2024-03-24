FROM php:8.2-cli

#COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini
COPY ./composer.json /data/composer.json

WORKDIR /data
VOLUME /data

RUN docker-php-ext-install sockets && docker-php-ext-enable sockets
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install && composer dump-autoload

CMD ["php","app.php","container_up"]