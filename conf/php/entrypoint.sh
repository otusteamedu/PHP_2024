#!/bin/sh

cd /src && composer install

exec php-fpm