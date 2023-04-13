FROM php:8.1-fpm-alpine

# Install necessary packages
RUN apk add --no-cache \
    nginx \
    sudo \
    postgresql-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Set up Nginx and PHP-FPM
COPY nginx.conf /etc/nginx/conf.d/

# Set up the Symfony application
WORKDIR /var/www/html
RUN sudo apk add --no-cache bash
RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' | sudo -E bash
RUN sudo apk add symfony-cli
RUN symfony new . --full --no-git
RUN chown -R nginx:nginx /var/www/html

# Expose port 80 for Nginx
EXPOSE 80

# Start Nginx and PHP-FPM
CMD ["sh", "-c", "php-fpm && nginx -g 'daemon off;'"]