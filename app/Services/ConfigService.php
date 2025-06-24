<?php

namespace App\Services;

/**
 * Provides structured access to application configuration from environment variables.
 */
class ConfigService
{
    private array $config;

    public function __construct()
    {
        $projectRoot = __DIR__;
        while (!file_exists($projectRoot . '/vendor/autoload.php') && $projectRoot !== '/') {
            $projectRoot = dirname($projectRoot);
        }

        $this->config = [
            'app_path' => $_ENV['APP_PATH'] ?? '/',
            'project_root' => $projectRoot,
            'domain' => $_ENV['DOMAIN'] ?? 'localhost',
            'is_dev' => ($_ENV['IS_DEV'] ?? 'false') === 'true',
            'cache_clear' => ($_ENV['CACHE_CLEAR'] ?? 'false') === 'true',
            'cache_ttl' => (int)($_ENV['CACHE_TTL'] ?? 3600), // Default 1 hour
            'database' => [
                'connection' => $_ENV['DB_CONNECTION'] ?? 'pgsql',
                'host'       => $_ENV['DB_HOST'] ?? 'db',
                'port'       => $_ENV['DB_PORT'] ?? 5432,
                'name'       => $_ENV['DB_DATABASE'] ?? 'myapp_db',
                'user'       => $_ENV['DB_USERNAME'] ?? 'myuser',
                'pass'       => $_ENV['DB_PASSWORD'] ?? 'mypassword',
            ],
            'vite' => [
                'server'        => $_ENV['VITE_DEV_SERVER'] ?? 'http://localhost:5173/',
                'client'        => ($_ENV['VITE_DEV_SERVER'] ?? 'http://localhost:5173/') . '@vite/client',
                'dist'          => ($_ENV['APP_PATH'] ?? '/') . 'dist/',
                'manifest_file' => $projectRoot . '/public/dist/.vite/manifest.json',
                'enable_full_reload' => ($_ENV['ENABLE_FULL_RELOAD'] ?? 'false') === 'true',
                'enable_hmr' => ($_ENV['ENABLE_HMR'] ?? 'false') === 'true',
            ],
            'contacts' => [
                'link'          => $_ENV['LINK'] ?? 'https://github.com/username/',
                'email'         => $_ENV['EMAIL'] ?? 'info@example.com',
                'telegram'      => $_ENV['TELEGRAM'] ?? 'https://t.me/yourtelegram',
                'phone'         => $_ENV['PHONE'] ?? '+1234567890',
                'address'       => $_ENV['ADDRESS'] ?? 'Example Street, Example City, Example Country',
                'company_name'  => $_ENV['COMPANY_NAME'] ?? 'Example Company Inc.',
            ],
            'social' => [
                'facebook'  => $_ENV['SOCIAL_FACEBOOK'] ?? '#',
                'instagram' => $_ENV['SOCIAL_INSTAGRAM'] ?? '#',
                'twitter'   => $_ENV['SOCIAL_TWITTER'] ?? '#',
                'linkedin'  => $_ENV['SOCIAL_LINKEDIN'] ?? '#',
                'youtube'   => $_ENV['SOCIAL_YOUTUBE'] ?? '#',
                'telegram'  => $_ENV['SOCIAL_TELEGRAM'] ?? '#',
            ],
            'images' => [
                'allowed_domains' => array_filter(array_map('trim', explode(',', $_ENV['ALLOWED_IMAGE_DOMAINS'] ?? ''))),
            ]
        ];
    }

    /**
     * Get a configuration value using dot notation (e.g., 'database.host').
     *
     * @param string $key The configuration key.
     * @param mixed $default The default value if the key is not found.
     * @return mixed
     */
    public function get(string $key, $default = null): mixed
    {
        $keys = explode('.', $key);
        $value = $this->config;

        foreach ($keys as $segment) {
            if (is_array($value) && isset($value[$segment])) {
                $value = $value[$segment];
            } else {
                return $default;
            }
        }

        return $value;
    }
}