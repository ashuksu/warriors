<?php
// Define the application path
define('APP_PATH', '/');
define('PROJECT_ROOT', dirname(__DIR__) . '/');

// Include the configuration
$config = require_once PROJECT_ROOT . 'config/config.php';

// Set content type
header('Content-Type: text/plain');

// Output robots.txt content
echo "User-agent: *\n";
echo "Disallow: /assets/\n";
echo "Disallow: /css/\n";
echo "Disallow: /js/\n";
echo "Disallow: /images/\n";
echo "Allow: /\n\n";
echo "Sitemap: https://" . $config['site']['domain'] . "/sitemap.xml\n";
?>
