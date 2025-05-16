<?php
// Define the application path
define('APP_PATH', '/');
define('PROJECT_ROOT', dirname(__DIR__) . '/');

// Include the configuration
$config = require_once PROJECT_ROOT . 'config/config.php';

// Set content type
header('Content-Type: application/xml');

// Generate sitemap
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

// Home page
echo '  <url>' . "\n";
echo '    <loc>https://' . $config['site']['domain'] . '/</loc>' . "\n";
echo '    <changefreq>weekly</changefreq>' . "\n";
echo '    <priority>1.0</priority>' . "\n";
echo '  </url>' . "\n";

// Catalog page
echo '  <url>' . "\n";
echo '    <loc>https://' . $config['site']['domain'] . '/catalog</loc>' . "\n";
echo '    <changefreq>weekly</changefreq>' . "\n";
echo '    <priority>0.8</priority>' . "\n";
echo '  </url>' . "\n";

// Contacts page
echo '  <url>' . "\n";
echo '    <loc>https://' . $config['site']['domain'] . '/contacts</loc>' . "\n";
echo '    <changefreq>monthly</changefreq>' . "\n";
echo '    <priority>0.8</priority>' . "\n";
echo '  </url>' . "\n";

echo '</urlset>';
?>