FROM php:8.3-fpm-alpine

# Установка зависимостей
RUN apk add --no-cache \
    curl git unzip libzip-dev oniguruma-dev \
    postgresql-dev\
    freetype-dev libjpeg-turbo-dev libpng-dev \
    && docker-php-ext-install pdo_pgsql zip mbstring gd

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Рабочая директория
WORKDIR /var/www/html

# Для dev: даём права на запись
RUN chown -R www-data:www-data /var/www/html

USER www-data
