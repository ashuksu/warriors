<?php
// Set content type to XML
header('Content-Type: application/xml; charset=utf-8');

// Include Composer autoloader
require_once __DIR__ . '/vendor/autoload.php';
// Ensure $DOMAIN is available
if (!isset($DOMAIN)) {
    $DOMAIN = $_SERVER['HTTP_HOST'] ?? 'warriors.example.com';
}

// Get the domain from config
$domain = $DOMAIN;

// Get current date in ISO 8601 format
$today = date('Y-m-d');

// Start XML output
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<!-- Sitemap for Warriors website -->' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

// Define pages with their priorities
$pages = [
    '' => ['priority' => '1.0', 'changefreq' => 'weekly'],
    'catalog/' => ['priority' => '0.8', 'changefreq' => 'weekly'],
    'contacts/' => ['priority' => '0.7', 'changefreq' => 'weekly'],
];

// Generate URL entries
foreach ($pages as $path => $settings) {
    echo "    <url>\n";
    echo "        <loc>https://{$domain}/{$path}</loc>\n";
    echo "        <lastmod>{$today}</lastmod>\n";
    echo "        <changefreq>{$settings['changefreq']}</changefreq>\n";
    echo "        <priority>{$settings['priority']}</priority>\n";
    echo "    </url>\n";
}

// Close XML
echo '</urlset>';
?>
