#!/bin/sh

cd /app && composer install
chmod 777 /var/run/php
php-fpm