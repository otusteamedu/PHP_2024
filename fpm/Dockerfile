# Use official PHP image as the base
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    libmemcached-dev \
    libz-dev \
    && docker-php-ext-install zip

# Install Composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Install Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Install Memcached extension
RUN pecl install memcached && docker-php-ext-enable memcached

# Set working directory
WORKDIR /var/www/html

# Copy the application files
COPY ./code /var/www/html

# Copy the .env file if needed (optional)
# COPY .env /var/www/html/.env

# Set permissions (if needed)
RUN chown -R www-data:www-data /var/www/html

# Expose port (optional, typically PHP-FPM uses 9000)
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
