FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /data/mysite.local

# Copy project files
COPY . .

# Install PHP dependencies
RUN if [ -f composer.json ]; then composer install --no-dev --optimize-autoloader; fi

CMD ["php-fpm"]
