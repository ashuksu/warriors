FROM php:8.2-apache

# Copy project files
COPY . /var/www/html/

# Enable mod_rewrite for Apache
RUN a2enmod rewrite

# Set access rights
RUN chown -R www-data:www-data /var/www/html/

# Open port
ONBUILD EXPOSE 80

# Command that will be executed when container starts
CMD ["apache2-foreground"]