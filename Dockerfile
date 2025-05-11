FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    && rm -rf /var/lib/apt/lists/*

# Configure nginx
RUN echo "server {\n\
    listen \$PORT;\n\
    root /var/www/html;\n\
    index index.php index.html;\n\
    location / {\n\
        try_files \$uri \$uri/ /index.php?\$query_string;\n\
    }\n\
    location ~ \.php$ {\n\
        fastcgi_pass 127.0.0.1:9000;\n\
        fastcgi_index index.php;\n\
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;\n\
        include fastcgi_params;\n\
    }\n\
}" > /etc/nginx/sites-available/default

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
sed -i "s/listen \$PORT/listen $PORT/" /etc/nginx/sites-available/default\n\
php-fpm -D\n\
nginx -g "daemon off;"' > /start.sh && \
    chmod +x /start.sh

# Expose the port
EXPOSE 80

# Start the application
CMD ["/start.sh"]