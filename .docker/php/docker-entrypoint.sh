#!/bin/sh
# Custom Docker entrypoint for PHP-FPM service.
# Selects php.ini configuration based on IS_DEV environment variable.

CUSTOM_INI_NAME="99-custom.ini"
PHP_CONF_DIR="/usr/local/etc/php/conf.d"

echo "Applying PHP configuration based on IS_DEV environment variable..."

if [ "$IS_DEV" = "true" ]; then
  echo "Development mode detected (IS_DEV=true). Using php-dev.ini."
  cp "${PHP_CONF_DIR}/php-dev.ini" "${PHP_CONF_DIR}/${CUSTOM_INI_NAME}"
else
  echo "Production mode detected (IS_DEV is not true). Using php-prod.ini."
  cp "${PHP_CONF_DIR}/php-prod.ini" "${PHP_CONF_DIR}/${CUSTOM_INI_NAME}"
fi

# Execute the original PHP entrypoint, passing all arguments to it.
# This ensures that PHP-FPM starts correctly with standard Docker PHP setup.
exec docker-php-entrypoint "$@"