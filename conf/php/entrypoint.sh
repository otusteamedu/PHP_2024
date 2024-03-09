#!/bin/sh

cd /src && composer install

cd ./app && php app.php $CLIENT_OR_SERVER