FROM php:8.3-fpm-alpine

RUN apk add --no-cache \
    curl git unzip libzip-dev oniguruma-dev \
    postgresql-dev\
    freetype-dev libjpeg-turbo-dev libpng-dev \
    && docker-php-ext-install pdo_pgsql zip mbstring gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html

USER www-data
