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