FROM php:8.2-fpm

RUN docker-php-ext-install sockets && docker-php-ext-enable sockets

#Installing composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN rm -rf composer-setup.php

CMD ["php-fpm"]
