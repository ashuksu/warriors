FROM php:8.3-fpm-alpine

# Set working directory for the application code
WORKDIR /var/www/html

# Install system dependencies required for PHP extensions and common tools
RUN apk add --no-cache \
    git \
    zip \
    unzip \
    libzip-dev \
    # For GD extension
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    # For Intl extension
    icu-dev

# Configure and install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    opcache \
    zip \
    pdo \
    pdo_mysql \
    gd \
    intl \
    bcmath
    # To add more extensions
    # bcmath \
    # sockets \
    # exif

# Install Composer globally using multi-stage build.
# This approach is good for ensuring you always have the latest Composer version.
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy the environment-specific php.ini files into a directory PHP scans.
# The entrypoint script will then select and activate the correct one.
COPY conf.d/php-dev.ini /usr/local/etc/php/conf.d/
COPY conf.d/php-prod.ini /usr/local/etc/php/conf.d/

# Copy the custom entrypoint script.
COPY docker-entrypoint.sh /usr/local/bin/

# Make the entrypoint script executable. This is crucial for it to run.
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Set the custom entrypoint. This script will execute first.
ENTRYPOINT ["docker-entrypoint.sh"]

# Set the default command for the container. This command is passed to the entrypoint script.
CMD ["php-fpm"]