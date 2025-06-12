#!/bin/sh
set -e

# Define constants for clarity and easier maintenance
CUSTOM_INI_NAME="zz-custom.ini"
PHP_CONF_DIR="/usr/local/etc/php/conf.d"

git config --global --add safe.directory /var/www/html || true

# Apply configuration based on IS_DEV environment variable
if [ "$IS_DEV" = "true" ]; then
    echo "PHP-FPM: Applying development configuration..."
    cp "${PHP_CONF_DIR}/php-dev.ini" "${PHP_CONF_DIR}/${CUSTOM_INI_NAME}"

    echo "PHP-FPM: Ensuring composer dev dependencies are installed..."
    composer install --no-interaction --no-progress --no-suggest
    echo "PHP-FPM: Regenerating development autoloader..."
    composer dump-autoload
else
    echo "PHP-FPM: Applying production configuration..."
    cp "${PHP_CONF_DIR}/php-prod.ini" "${PHP_CONF_DIR}/${CUSTOM_INI_NAME}"
fi

# Hand over control to the default PHP entrypoint or the provided command.
exec docker-php-entrypoint "$@"