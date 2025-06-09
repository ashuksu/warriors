<?php
header('Content-Type: application/xml; charset=utf-8');

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$domain = $_ENV['DOMAIN'] ?? $_SERVER['HTTP_HOST'];
$today = date('Y-m-d');
$isProduction = !($_ENV['IS_DEV'] ?? false);

if (!$isProduction) {
    die('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');
}

$pages = [
    '' => ['priority' => '1.0', 'changefreq' => 'weekly'],
    'catalog/' => ['priority' => '0.8', 'changefreq' => 'weekly'],
    'contacts/' => ['priority' => '0.7', 'changefreq' => 'weekly']
];

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" 
             xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";

foreach ($pages as $path => $settings) {
    echo "    <url>\n";
    echo "        <loc>https://{$domain}/{$path}</loc>\n";
    echo "        <lastmod>{$today}</lastmod>\n";
    echo "        <changefreq>{$settings['changefreq']}</changefreq>\n";
    echo "        <priority>{$settings['priority']}</priority>\n";
    echo "    </url>\n";
}

echo '</urlset>';