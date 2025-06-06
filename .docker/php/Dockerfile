FROM php:8.3-fpm-alpine

# Set working directory for the application code
WORKDIR /var/www/html

# Install system dependencies required for PHP extensions
RUN apk add --no-cache \
    curl \
    git \
    zip \
    unzip \
    libzip-dev \
    libsodium-dev \
    postgresql-dev \
    imagemagick-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    icu-dev \
    linux-headers \
    # For development, install nodejs and npm
    # For production, these are not strictly needed in FPM container
    nodejs \
    npm

# Configure and install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    opcache \
    zip \
    pdo \
    pdo_mysql \
    gd \
    intl \
    bcmath \
    sockets \
    exif \
    sodium \
    pcntl \
    pdo_pgsql

# Install Composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy the environment-specific php.ini files into a directory PHP scans.
COPY conf.d/php-dev.ini /usr/local/etc/php/conf.d/
COPY conf.d/php-prod.ini /usr/local/etc/php/conf.d/

# Copy the custom entrypoint script and make it executable.
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Expose port for PHP-FPM
EXPOSE 9000

# Use the custom entrypoint
ENTRYPOINT ["docker-entrypoint.sh"]

# Default command if no command is provided
CMD ["php-fpm"]