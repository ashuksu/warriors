<?php

namespace Helpers;

/**
 * Helper functions for the application
 */

/**
 * Render a template file with parameters
 *
 * Extracts the parameters into variables and includes the template file
 *
 * @param string $templatePath Path to the template file
 * @param array $params Associative array of parameters to be available in the template
 * @return void
 */
function renderTemplate($templatePath, $params = [])
{
    extract($params);
    require $templatePath;
}

/**
 * Get the appropriate asset path based on the environment
 *
 * @param string $path The relative path to the asset
 * @return string The full path to the asset
 */
function getPath(string $path): string
{
    // Use Vite server in dev mode only if it's running
    if (defined('IS_DEV') && IS_DEV) {
        return VITE_DEV_SERVER . $path;
    }

    return APP_PATH . $path;
}