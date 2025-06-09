<?php
header('Content-Type: text/plain; charset=utf-8');

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$domain = $_ENV['DOMAIN'] ?? $_SERVER['HTTP_HOST'];
$isProduction = !($_ENV['IS_DEV'] ?? false);

echo "# Allow all search engines to access the site\n\n";
echo "User-agent: *\n";

if (!$isProduction) {
    echo "Disallow: /\n";
} else {
    echo "# Prevent access to system directories\n";
    echo "Disallow: /404/\n";
    echo "Disallow: /private/\n";
    echo "Disallow: /admin/\n";
    echo "Disallow: /.git/\n";
    echo "Disallow: /.idea/\n\n";

    echo "# Allow static assets\n";
    echo "Allow: /*.css$\n";
    echo "Allow: /*.js$\n";
    echo "Allow: /*.png$\n";
    echo "Allow: /*.jpg$\n";
    echo "Allow: /*.gif$\n";
    echo "Allow: /*.svg$\n";
    echo "Allow: /*.webp$\n\n";

    echo "# Block dynamic parameters\n";
    echo "Disallow: *?*sort=\n";
    echo "Disallow: *?*filter=\n";
    echo "Disallow: *?*page=\n\n";

    echo "Crawl-delay: 5\n\n";
}

echo "# Sitemap location\n";
echo "Sitemap: https://{$domain}/sitemap.php\n";