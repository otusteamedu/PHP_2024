FROM php:8.2-cli

WORKDIR /app

# Устанавливаем необходимые зависимости для расширений
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip \
    libpq-dev \
    curl \
    git \
    && docker-php-ext-install bcmath sockets zip pdo_pgsql

# Установка Xdebug
RUN pecl install xdebug \
&& docker-php-ext-enable xdebug

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    chmod +x /usr/local/bin/composer

COPY ./docker/worker/wait-for-it.sh /wait-for-it.sh
RUN chmod +x /wait-for-it.sh

COPY ./app /app

# Запуск worker
CMD ["/wait-for-it.sh", "rabbitmq:5672", "--", "php", "/app/backend/src/Infrastructure/Queue/QueueWorker.php"]
