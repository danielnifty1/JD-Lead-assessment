# Stage 0: Composer
FROM composer:latest as composer

# Stage 1: Node for building assets
FROM node:18 as nodebuild
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: PHP + Apache
FROM php:8.2-apache

# Install PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip gd

# Enable Apache Rewrite
RUN a2enmod rewrite

# Set Apache to serve from public/
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

# Set working directory
WORKDIR /var/www/html

# Copy Laravel app
COPY . .

# Copy built assets
COPY --from=nodebuild /app/public/build public/build

# Copy composer binary
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev

# Set permissions
RUN mkdir -p storage/logs bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R ug+rwx storage bootstrap/cache

# Do not run artisan setup during build, run at container startup if needed
# Start Apache
EXPOSE 80
CMD ["apache2-foreground"]
