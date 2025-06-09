#!/bin/sh
set -e

# This script sets up the environment (dev vs. prod) and then executes
# the command passed to the container (e.g., 'php-fpm').

CUSTOM_INI_NAME="zz-custom.ini"
PHP_CONF_DIR="/usr/local/etc/php/conf.d"

# Configure Git safe directory for Composer in case of mounted volumes.
git config --global --add safe.directory /app || true

# Apply PHP configuration based on IS_DEV environment variable.
if [ "$IS_DEV" = "true" ]; then
    echo "PHP-FPM: Applying development configuration..."
    # In development, dynamically link/copy the dev.ini.
    # php-dev.ini and php-prod.ini are both copied into the image by Dockerfile-dev.
    cp "${PHP_CONF_DIR}/php-dev.ini" "${PHP_CONF_DIR}/${CUSTOM_INI_NAME}"

    echo "PHP-FPM: Ensuring Composer dev dependencies are installed..."
    # Install dev dependencies only in development.
    composer install --no-interaction --no-progress --no-suggest
    echo "PHP-FPM: Regenerating development autoloader..."
    composer dump-autoload
else
    echo "PHP-FPM: Applying production configuration..."
    # In production, php-prod.ini is already copied and named 'zz-custom.ini'
    # by Dockerfile.prod. No runtime php.ini copying is needed here.
    # Production Composer dependencies are installed during the image build.
fi

# Hand over control to the default PHP entrypoint or the provided command.
exec docker-php-entrypoint "$@"