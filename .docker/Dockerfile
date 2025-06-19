# --- Stage: base ---
FROM php:8.3-fpm-alpine AS base
WORKDIR /var/www/html
RUN apk update && apk add --no-cache \
    $PHPIZE_DEPS \
    curl git zip unzip libzip-dev libsodium-dev postgresql-dev \
    imagemagick-dev libpng-dev libjpeg-turbo-dev freetype-dev icu-dev \
    php83-dev linux-headers autoconf make \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    opcache zip pdo pdo_mysql pdo_pgsql gd intl bcmath sockets exif sodium pcntl \
    && pecl install apcu && docker-php-ext-enable apcu \
    && rm -rf /var/cache/apk/* \
    && git config --global --add safe.directory /var/www/html
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer


# --- Stage: dev ---
FROM base AS dev
RUN apk add --no-cache vips-dev build-base python3 \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug
COPY .docker/php/conf.d/php-dev.ini /usr/local/etc/php/conf.d/zz-dev-settings.ini
CMD ["php-fpm"]


# --- Stage: prod_builder ---
FROM base AS prod_builder
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-interaction --no-progress --no-suggest --no-dev --optimize-autoloader


# --- Stage: frontend_builder ---
FROM node:20-alpine AS frontend_builder
WORKDIR /app
COPY package*.json ./
RUN npm ci && npm cache clean --force
COPY . .
RUN npm run build


# --- Stage: prod (Final PHP Production Image) ---
FROM base AS prod
WORKDIR /var/www/html
COPY .docker/php/conf.d/php-prod.ini /usr/local/etc/php/conf.d/zz-prod-settings.ini
COPY . .
COPY --from=prod_builder /app/vendor ./vendor
COPY --from=frontend_builder /app/public ./public
RUN chown -R www-data:www-data /var/www/html
EXPOSE 9000
CMD ["php-fpm"]


# --- Stage: nginx ---
FROM nginx:stable-alpine AS nginx
COPY .docker/nginx/conf.d/default-prod.conf /etc/nginx/conf.d/default.conf
COPY .docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY --from=prod /var/www/html /var/www/html
RUN chown -R nginx:nginx /var/www/html
EXPOSE 80
EXPOSE 443
CMD ["nginx", "-g", "daemon off;"]


# --- Stage: vite ---
FROM node:20-alpine AS vite
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
EXPOSE 5173
CMD ["npm", "run", "dev", "--", "--host", "0.0.0.0"]