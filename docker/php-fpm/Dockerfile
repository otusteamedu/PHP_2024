FROM php:8.3-fpm

#COPY ./conf/php.ini /usr/local/etc/php/conf.d/php-custom.ini

ENV TIMEZONE Europe/Moscow

# Определяем временные переменные окружения
ENV PHP_INI_PATH /usr/local/etc/php/php.ini
ENV PHP_EXT_XDEBUG_INI_PATH /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN apt-get update
RUN apt-get install -y \
		libfreetype-dev \
		libjpeg62-turbo-dev \
		libpng-dev

RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) gd


RUN apt-get update && apt-get install -y \
        curl \
        wget \
        git \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        libjpeg-dev \
        libxpm-dev \
        libwebp-dev \
        libmcrypt-dev \
        libcurl4-openssl-dev \
        zlib1g-dev \
        zip \
        unzip \
        libpq-dev \
        libzip-dev \
        libsodium-dev \
        libmagickwand-dev --no-install-recommends \
        libmemcached-dev

# Install PHP extensions
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql

# xdebug
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug
COPY conf/xdebug.ini ${PHP_EXT_XDEBUG_INI_PATH}

RUN pecl install redis \
    && docker-php-ext-enable redis

RUN pecl install memcached
RUN echo extension=memcached.so >> /usr/local/etc/php/conf.d/memcached.ini

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install zip pdo pdo_mysql mbstring sodium exif pcntl bcmath pgsql pdo_pgsql gettext
RUN docker-php-ext-enable pdo pdo_mysql mbstring sodium exif pcntl bcmath gd pgsql pdo_pgsql gettext

RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini

# Изменяем значение cgi.fix_pathinfo в php.ini
RUN sed -i 's/;cgi.fix_pathinfo=.*/cgi.fix_pathinfo=0/' /usr/local/etc/php/php.ini

# Устанавливаем параметры для сессий
RUN sed -i 's/;session.save_handler = .*/session.save_handler = redis/' ${PHP_INI_PATH}
RUN sed -i 's/;session.save_path = .*/session.save_path = "tcp:\/\/redis:${REDIS_CONTAINER_PORT}"/' ${PHP_INI_PATH}

# Устанавливаем параметры для ошибок
ARG ENVIRONMENT
RUN if [ "$ENVIRONMENT" = "prod" ]; then \
        sed -i 's/;error_reporting = .*/error_reporting = E_ALL & ~E_DEPRECATED & ~E_STRICT/' ${PHP_INI_PATH} && \
        sed -i 's/;display_errors = .*/display_errors = Off/' ${PHP_INI_PATH}; \
    elif [ "$ENVIRONMENT" = "dev" ]; then \
        sed -i 's/;error_reporting = .*/error_reporting = E_ALL/' ${PHP_INI_PATH} && \
        sed -i 's/;display_errors = .*/display_errors = On/' ${PHP_INI_PATH}; \
    else \
        echo "Неизвестное значение ENVIRONMENT: $ENVIRONMENT"; \
    fi

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install TimeZone
RUN cp /usr/share/zoneinfo/${TIMEZONE} /etc/localtime \
    && echo "${TIMEZONE}" > /etc/timezone

WORKDIR /src/public

VOLUME /src/public

CMD ["php-fpm"]
