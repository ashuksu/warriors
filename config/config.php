<?php
// Main configuration file

// Path definitions
define('APP_PATH', '/');
define('PROJECT_ROOT', dirname(__DIR__) . '/');

// Site information
$config = [
    'site' => [
        'domain' => $_SERVER['HTTP_HOST'] ?? 'warriors.example.com',
        'link' => 'https://github.com/ashuksu/',
        'email' => 'ashuksu@gmail.com',
        'telegram' => 'https://t.me/ashuksu'
    ],
    'paths' => [
        'data' => PROJECT_ROOT . 'app/Data/',
        'views' => PROJECT_ROOT . 'app/Views/',
        'assets' => APP_PATH . 'assets/'
    ]
];

// Make config globally available
$DOMAIN = $config['site']['domain'];
$LINK = $config['site']['link'];
$EMAIL = $config['site']['email'];
$TELEGRAM = $config['site']['telegram'];

return $config;
?>