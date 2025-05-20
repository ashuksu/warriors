<?php

namespace App\Helpers;

class Vite
{
    private static string $manifestFile = __DIR__ . '/../../public/dist/.vite/manifest.json';
    private static ?array $manifest = null;

    public static function assets(): array
    {
        if (defined('IS_DEV') && IS_DEV && isViteServerRunning()) {
            return [
                'styles' => [
                    ['href' => getAssetPath('src/scss/main.scss')],
                    ['href' => getAssetPath('src/css/style.css')],
                    ['href' => getAssetPath('src/css/criticalStyles.css')]
                ],
                'scripts' => [
                    ['src' => VITE_DEV_CLIENT, 'type' => 'module'],
                    ['src' => getAssetPath('src/js/script.js'), 'type' => 'module']
                ]
            ];
        }

        $manifest = self::getManifest();

        if (!$manifest) {
            throw new \RuntimeException('Vite manifest file not found. Please run npm run build first.');
        }

        $styles = [];
        $scripts = [];

        foreach ($manifest as $entry => $file) {
            if (str_ends_with($entry, '.css') || str_ends_with($entry, '.scss')) {
                $styles[] = ['href' => '/dist/' . $file['file']];
            } else if (str_ends_with($entry, '.js')) {
                $scripts[] = [
                    'src' => '/dist/' . $file['file'],
                    'type' => 'module'
                ];
            }
        }

        return [
            'styles' => $styles,
            'scripts' => $scripts
        ];
    }

    private static function getManifest(): ?array
    {
        if (self::$manifest !== null) {
            return self::$manifest;
        }

        if (!file_exists(self::$manifestFile)) {
            return null;
        }

        self::$manifest = json_decode(file_get_contents(self::$manifestFile), true);
        return self::$manifest;
    }
}