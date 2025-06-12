# --- Stage 1: Frontend Builder ---
FROM node:20-alpine AS frontend-builder
RUN apk add --no-cache vips-dev build-base python3
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# --- Stage 2: Final PHP-FPM Image ---
FROM php:8.3-fpm-alpine
RUN apk add --no-cache \
    curl git zip unzip libzip-dev libsodium-dev postgresql-dev \
    imagemagick-dev libpng-dev libjpeg-turbo-dev freetype-dev icu-dev linux-headers;
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    opcache zip pdo pdo_mysql gd intl bcmath sockets exif sodium pcntl pdo_pgsql;
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
COPY . .
COPY --from=frontend-builder /app/public/dist ./public/dist/
COPY .docker/php/conf.d/php-dev.ini /usr/local/etc/php/conf.d/
COPY .docker/php/conf.d/php-prod.ini /usr/local/etc/php/conf.d/
RUN composer install --no-interaction --no-progress --no-suggest --no-dev --optimize-autoloader
COPY .docker/php/docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh
RUN chown -R www-data:www-data /var/www/html
EXPOSE 9000
ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["php-fpm"]