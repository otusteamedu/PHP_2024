FROM php:8.2-cli

RUN apt-get update && \
    apt-get install -y unzip libcurl4-openssl-dev && \
    docker-php-ext-install curl

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer require elasticsearch/elasticsearch

WORKDIR /app
COPY . .

CMD ["php", "app.php"]
