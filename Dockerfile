# Use the official PHP + Apache image
FROM php:8.2-apache

# Copy all files to the Apache server root
COPY . /var/www/html/

# Enable Apache mod_rewrite (optional for routing)
RUN a2enmod rewrite

# Expose default Apache port
EXPOSE 80
