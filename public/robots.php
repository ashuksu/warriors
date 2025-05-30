<?php
// Set content type to text/plain
header('Content-Type: text/plain; charset=utf-8');

// Include Composer autoloader
require_once __DIR__ . '/vendor/autoload.php';
// Ensure $DOMAIN is available
if (!isset($DOMAIN)) {
    $DOMAIN = $_SERVER['HTTP_HOST'] ?? 'warriors.example.com';
}

// Get the domain from config
$domain = $DOMAIN;

// Output robots.txt content
echo "# robots.txt for Warriors website\n";
echo "# This file tells search engine crawlers which pages they can or cannot request from your site\n\n";

echo "# Allow all search engines to access the site\n";
echo "User-agent: *\n\n";

echo "# Prevent access to these directories\n";
echo "Disallow: /404/        # Error page\n";
echo "Disallow: /private/    # Private content\n";
echo "Disallow: /admin/      # Admin area\n";
echo "Disallow: /.git/       # Git repository\n";
echo "Disallow: /.idea/      # IDE files\n\n";

echo "# Allow specific file types\n";
echo "Allow: /*.css$\n";
echo "Allow: /*.js$\n";
echo "Allow: /*.png$\n";
echo "Allow: /*.jpg$\n";
echo "Allow: /*.gif$\n";
echo "Allow: /*.svg$\n";
echo "Allow: /*.webp$\n\n";

echo "# Block specific parameters\n";
echo "Disallow: *?*sort=\n";
echo "Disallow: *?*filter=\n";
echo "Disallow: *?*page=\n\n";

echo "# Crawl-delay to prevent server overload (in seconds)\n";
echo "Crawl-delay: 5\n\n";

echo "# Location of the sitemap file\n";
echo "Sitemap: https://{$domain}/sitemap.php\n";
?>
