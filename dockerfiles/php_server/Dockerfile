FROM php:8.2-cli

WORKDIR /data/application

#CURL
RUN apt-get update && apt-get install -y curl libssl-dev zlib1g-dev libzip-dev

#Подключение сокетов
RUN docker-php-ext-install sockets && docker-php-ext-enable sockets

#Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

CMD [ "php", "app.php", "waiter"]