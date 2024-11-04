FROM php:8.3-fpm

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions \
    mysqli \
    pdo_mysql \
    zip \
    intl \
    opcache \
    bcmath \
    @composer

WORKDIR /var/www/html