# Stage 1: Node for building assets
FROM node:18 as nodebuild
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: PHP Apache with Laravel
FROM php:8.2-apache

# Install extensions and tools
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip gd

# Enable mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy Laravel code
COPY . .

# Copy assets from Node build
COPY --from=nodebuild /app/public/build public/build

# Use public/ as doc root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --optimize-autoloader --no-dev

# Copy env and generate key
COPY .env.example .env
RUN php artisan key:generate

# Fix permissions
RUN chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

# Run Laravel setup commands
RUN php artisan config:cache && \
    php artisan migrate --force && \
    php artisan storage:link || true

EXPOSE 80
CMD ["apache2-foreground"]
