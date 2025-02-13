#!/bin/bash

composer install

php bin/console doctrine:cache:clear-metadata
php bin/console doctrine:cache:clear-query
php bin/console doctrine:cache:clear-result
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console cache:clear

chown -R www-data:www-data var

php-fpm
