# Stage 0: Composer for installing PHP deps
FROM composer:latest as composer

# Stage 1: Node for building assets
FROM node:18 as nodebuild
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: PHP Apache with Laravel
FROM php:8.2-apache

# Install PHP extensions and tools
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip gd

# Enable mod_rewrite for Laravel
RUN a2enmod rewrite

# Set public directory as the Apache root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

# Set working directory
WORKDIR /var/www/html

# Copy Laravel codebase
COPY . .

# Copy built assets from Node stage
COPY --from=nodebuild /app/public/build public/build

# Copy Composer from the correct stage
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev

# Fix permissions for Laravel directories
RUN mkdir -p storage/logs && \
    chown -R www-data:www-data storage bootstrap/cache storage/logs && \
    find storage bootstrap/cache storage/logs -type d -exec chmod 775 {} \; && \
    find storage bootstrap/cache storage/logs -type f -exec chmod 664 {} \;

# Run Laravel setup commands (ignore storage:link failure gracefully)
RUN php artisan config:cache && \
    php artisan migrate --force && \
    php artisan storage:link || true

EXPOSE 80
CMD ["apache2-foreground"]
