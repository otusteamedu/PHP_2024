FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
	&& docker-php-ext-install sockets

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet --version=2.1.3

CMD [ "php", "index.php", "receiver"]
