ARG PHP_VERSION=8.3-cli

FROM php:${PHP_VERSION}

RUN docker-php-ext-install sockets

COPY docker/php-app/php.ini $PHP_INI_DIR/conf.d/php.ini

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && php composer-setup.php --install-dir=/usr/local/bin --filename=composer

RUN usermod -u 1000 www-data

COPY --chown=www-data:www-data chat-app/ /chat-app

RUN chown -R www-data:www-data /chat-app

WORKDIR /chat-app

USER www-data

RUN export COMPOSER_HOME=$(pwd) && composer --no-progress --prefer-dist --no-interaction install;

ENTRYPOINT [ "php", "./src/app.php" ]
