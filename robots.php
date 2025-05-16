<?php
// Set content type to text/plain
header('Content-Type: text/plain; charset=utf-8');

// Include configuration
require_once __DIR__ . '/config.php';

// Get the domain from config or use the server hostname
$domain = $_SERVER['HTTP_HOST'] ?? 'warriors.example.com';

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

echo "# Crawl-delay to prevent server overload (in seconds)\n";
echo "Crawl-delay: 10\n\n";

echo "# Location of the sitemap file\n";
echo "Sitemap: /sitemap.xml\n";
?>
