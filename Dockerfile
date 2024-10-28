# Use the official PHP image with Apache
FROM php:apache

# Install the mysqli extension
RUN docker-php-ext-install mysqli

# Copy your application files to the appropriate directory
COPY ./ /var/www/html/

# Expose ports 80 and 443
EXPOSE 80 443