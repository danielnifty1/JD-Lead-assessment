FROM node:18 as node

# Build Vite assets
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# PHP image
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    zip unzip git curl libzip-dev libpng-dev libonig-dev libxml2-dev \
    libcurl4-openssl-dev default-mysql-client \
    && docker-php-ext-install pdo pdo_mysql zip gd

# Enable Apache rewrite
RUN a2enmod rewrite

# Set Laravel working dir
WORKDIR /var/www/html

# Copy Laravel app
COPY . .

# Copy Vite build from Node stage
COPY --from=node /app/public/build ./public/build

# Install Composer and dependencies
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-interaction --optimize-autoloader

# Set correct document root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
 && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN if [ -f storage/logs/laravel.log ]; then tail -n 50 storage/logs/laravel.log; else echo "No logs found"; fi


# Laravel artisan setup
RUN php artisan config:cache && \
    php artisan storage:link

EXPOSE 80
CMD ["apache2-foreground"]


