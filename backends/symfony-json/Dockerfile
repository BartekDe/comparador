FROM php:8.1-fpm-alpine

# Install necessary packages
RUN apk add --no-cache \
    nginx \
    bash \
    sudo \
    postgresql-dev \
    && docker-php-ext-install pdo pdo_pgsql

WORKDIR /var/www/html
RUN chown -R nginx:nginx /var/www/html