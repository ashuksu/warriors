#!/bin/sh
set -e

# Config for custom PHP INI files
CUSTOM_INI_NAME="zz-custom.ini"
PHP_CONF_DIR="/usr/local/etc/php/conf.d"

# Apply PHP configuration based on IS_DEV environment variable
if [ "$IS_DEV" = "true" ]; then
    echo "PHP-FPM: Development mode (php-dev.ini)"
    cp "${PHP_CONF_DIR}/php-dev.ini" "${PHP_CONF_DIR}/${CUSTOM_INI_NAME}"
else
    echo "PHP-FPM: Production mode (php-prod.ini)"
    cp "${PHP_CONF_DIR}/php-prod.ini" "${PHP_CONF_DIR}/${CUSTOM_INI_NAME}"
fi

# Execute the default PHP-FPM entry point
exec docker-php-entrypoint "$@"