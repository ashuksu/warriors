<?php
namespace App\Helpers;

class Vite
{
    private static string $devServerUrl = 'http://localhost:5173';
    private static string $manifestPath = __DIR__ . '/../../public/dist/manifest.json';

    private static function isDevServerRunning(): bool
    {
        $ch = curl_init(self::$devServerUrl . '/@vite/client');
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 300);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $httpCode === 200;
    }

    public static function assets(): array
    {
        if (self::isDevServerRunning()) {
            return [
                'scripts' => [
                    ['src' => self::$devServerUrl . '/@vite/client', 'type' => 'module'],
                    ['src' => self::$devServerUrl . '/src/js/script.js', 'type' => 'module']
                ],
                'styles' => [
                    ['href' => self::$devServerUrl . '/src/css/style.css'],
                    ['href' => self::$devServerUrl . '/src/css/criticalStyles.css'],
                    ['href' => self::$devServerUrl . '/src/scss/main.scss']
                ]
            ];
        }

        if (!file_exists(self::$manifestPath)) {
            throw new \RuntimeException('Vite manifest file not found. Please run npm run build first.');
        }

        $manifest = json_decode(file_get_contents(self::$manifestPath), true);
        if ($manifest === null) {
            throw new \RuntimeException('Vite manifest file is not valid JSON');
        }

        $scripts = [];
        $styles = [];

        if (isset($manifest['src/js/script.js'])) {
            $entry = $manifest['src/js/script.js'];
            $scripts[] = [
                'src' => '/dist/' . $entry['file'],
                'type' => 'module'
            ];

            if (isset($entry['css']) && is_array($entry['css'])) {
                foreach ($entry['css'] as $cssFile) {
                    $styles[] = ['href' => '/dist/' . $cssFile];
                }
            }
        }

        $cssEntries = [
            'src/css/style.css',
            'src/css/criticalStyles.css',
            'src/scss/main.scss'
        ];

        foreach ($cssEntries as $cssEntry) {
            if (isset($manifest[$cssEntry])) {
                $styles[] = ['href' => '/dist/' . $manifest[$cssEntry]['file']];
            }
        }

        // Поиск дополнительных CSS файлов в манифесте
        foreach ($manifest as $key => $entry) {
            if (str_ends_with($key, '.css') || str_ends_with($key, '.scss')) {
                if (!in_array(['href' => '/dist/' . $entry['file']], $styles)) {
                    $styles[] = ['href' => '/dist/' . $entry['file']];
                }
            }
        }

        return [
            'scripts' => $scripts,
            'styles' => $styles
        ];
    }
}