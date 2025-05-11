
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    && rm -rf /var/lib/apt/lists/*

# Configure nginx
COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
RUN rm /etc/nginx/sites-enabled/default
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Create required directories
RUN mkdir -p /run/nginx && \
    mkdir -p /var/log/nginx && \
    mkdir -p /var/www/html

# Copy project files
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html/ && \
    chown -R www-data:www-data /var/log/nginx && \
    chown -R www-data:www-data /run/nginx && \
    chmod -R 755 /var/www/html/

# Create startup script
RUN echo '#!/bin/bash\n\
sed -i "s/80/$PORT/g" /etc/nginx/conf.d/default.conf\n\
php-fpm -D\n\
nginx -g "daemon off;"' > /start.sh && \
    chmod +x /start.sh

# Expose the port
EXPOSE 80

# Start the application
CMD ["/start.sh"]