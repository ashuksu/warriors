# --- Stage: dev ---
FROM php:8.3-fpm-alpine AS dev
RUN apk update && apk add --no-cache \
    $PHPIZE_DEPS git curl zip unzip libzip-dev libsodium-dev postgresql-dev \
    imagemagick-dev libpng-dev libjpeg-turbo-dev freetype-dev icu-dev linux-headers \
    vips-dev build-base python3 \
    && pecl install xdebug \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install -j$(nproc) \
    opcache zip pdo pdo_mysql pdo_pgsql gd intl bcmath sockets exif sodium pcntl \
    && rm -rf /var/cache/apk/* \
    && git config --global --add safe.directory /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
WORKDIR /var/www/html
COPY composer.json composer.lock ./
RUN composer install --no-interaction --no-progress --no-suggest
COPY .docker/php/conf.d/php-dev.ini /usr/local/etc/php/conf.d/zz-dev-settings.ini
COPY . .
RUN chown -R www-data:www-data /var/www/html
CMD ["php-fpm"]


# --- Stage: prod_base ---
FROM php:8.3-fpm-alpine AS prod_base
RUN apk update && apk add --no-cache \
    curl git zip unzip libzip-dev libsodium-dev postgresql-dev \
    imagemagick-dev libpng-dev libjpeg-turbo-dev freetype-dev icu-dev linux-headers \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    opcache zip pdo pdo_mysql pdo_pgsql gd intl bcmath sockets exif sodium pcntl \
    && rm -rf /var/cache/apk/*


# --- Stage: composer_prod ---
FROM prod_base AS composer_prod
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-interaction --no-progress --no-suggest --no-dev --optimize-autoloader


# --- Stage: frontend_prod ---
FROM node:20-alpine AS frontend_prod
WORKDIR /app
COPY package*.json ./
RUN npm ci && npm cache clean --force
COPY . .
RUN npm run build


# --- Stage: prod (Final PHP Production Image) ---
FROM prod_base AS prod
WORKDIR /var/www/html
COPY .docker/php/conf.d/php-prod.ini /usr/local/etc/php/conf.d/zz-prod-settings.ini
COPY . .
COPY --from=composer_prod /app/vendor ./vendor
COPY --from=frontend_prod /app/public ./public
RUN chown -R www-data:www-data /var/www/html

EXPOSE 9000
CMD ["php-fpm"]


# --- Stage: nginx-prod (Final Nginx Production Image) ---
FROM nginx:stable-alpine AS nginx-prod
COPY --from=frontend_prod /app/public /var/www/html/public
RUN rm -f /etc/nginx/conf.d/default.conf
COPY .docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY .docker/nginx/conf.d/default-prod.conf /etc/nginx/conf.d/default.conf
RUN mkdir -p /var/log/nginx && chown -R nginx:nginx /var/www/html /var/log/nginx \
    && chmod 644 /etc/nginx/nginx.conf /etc/nginx/conf.d/default.conf

EXPOSE 80
EXPOSE 443
CMD ["nginx", "-g", "daemon off;"]


# --- Stage: vite (Vite Dev Server) ---
FROM node:20-alpine AS vite
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
EXPOSE 5173
CMD ["npm", "run", "dev", "--", "--host", "0.0.0.0"]