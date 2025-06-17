FROM php:8.2-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    zip unzip git curl libzip-dev libpng-dev libonig-dev libxml2-dev \
    libcurl4-openssl-dev default-mysql-client \
    && docker-php-ext-install pdo pdo_mysql zip gd

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy Laravel files into container
COPY . .

# Set the correct document root for Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Update Apache config to use /public as root
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
 && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

CMD ["apache2-foreground"]

RUN php artisan config:cache && php artisan migrate --force
