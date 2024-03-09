FROM php:7.4-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet --version=2.1.3

WORKDIR /src

COPY ./entrypoint.sh /usr/local/bin/docker-php-entrypoint
RUN chmod +x /usr/local/bin/docker-php-entrypoint

ENTRYPOINT ["/usr/local/bin/docker-php-entrypoint"]