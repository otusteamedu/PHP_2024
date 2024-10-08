FROM php:8.2.20-cli

RUN apt-get update && apt-get install -y
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions xdebug-3.3.1

EXPOSE 9003

WORKDIR /code/public
