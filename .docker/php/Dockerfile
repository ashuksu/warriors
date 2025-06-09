# --- Stage 1: Frontend Builder ---
# This stage builds frontend assets. It includes Node.js and dev dependencies.
# It will not be part of the final, lean PHP image.
FROM node:20-alpine AS frontend-builder

# Install dependencies needed for `sharp` image processing library.
RUN apk add --no-cache vips-dev build-base python3

WORKDIR /app

# Copy package files and install ALL dependencies (including devDependencies for build)
COPY package*.json ./
RUN npm install

# Copy the entire application source code. .dockerignore will prevent
# node_modules, .git etc. on the host from being copied.
COPY . .

# Build the frontend assets. This will create the /app/public/dist directory.
RUN npm run build


# --- Stage 2: Final PHP-FPM Image ---
# This is the final, optimized production image.
# It does NOT contain Node.js or any frontend dev dependencies.
FROM php:8.3-fpm-alpine

# Install system dependencies required for PHP extensions and Composer
RUN apk add --no-cache \
    curl git zip unzip libzip-dev libsodium-dev postgresql-dev \
    imagemagick-dev libpng-dev libjpeg-turbo-dev freetype-dev icu-dev linux-headers;

# Configure and install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    opcache zip pdo pdo_mysql gd intl bcmath sockets exif sodium pcntl pdo_pgsql;

# Install Composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy application source code from the build context (your project root)
# Note: This does not include vendor or node_modules due to .dockerignore
COPY . .

# Copy ONLY the built frontend assets from the 'frontend-builder' stage
COPY --from=frontend-builder /app/public/dist ./public/dist/

# Copy environment-specific php.ini files. The entrypoint will select the correct one.
COPY .docker/php/conf.d/php-dev.ini /usr/local/etc/php/conf.d/
COPY .docker/php/conf.d/php-prod.ini /usr/local/etc/php/conf.d/

# Run composer install to get PHP dependencies for PRODUCTION.
# Development dependencies will be installed by the entrypoint script if needed.
RUN composer install --no-interaction --no-progress --no-suggest --no-dev --optimize-autoloader

# Copy the custom entrypoint script and make it executable.
COPY .docker/php/docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Ensure the application directory is owned by the web server user for proper permissions.
RUN chown -R www-data:www-data /var/www/html

# Expose port for PHP-FPM
EXPOSE 9000

# Use the custom entrypoint
ENTRYPOINT ["docker-entrypoint.sh"]

# Default command to run
CMD ["php-fpm"]