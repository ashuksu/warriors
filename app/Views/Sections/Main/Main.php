<?php

namespace App\Views\Sections\Main;

use App\Core\Container;
use App\Services\SectionService;
use Exception;
use function App\Helpers\renderTemplate;
use function App\Helpers\getPath;

class Main
{
    /**
     * Render the section with provided parameters.
     *
     * @param Container $container
     * @return void
     * @throws Exception
     */
    public static function render(Container $container): void
    {
        $popups = SectionService::get('popup', 'items');
        $image = SectionService::get('main', 'image');

        renderTemplate(__DIR__ . '/template.php', params: [
            'item' => SectionService::get('main'),
            'section' => 'main',
            'image' => $image,
            'imagePath' => getPath('dist/assets/images/' . ($image['image'] ?? '')),
            'popups' => $popups,
            'isPopups' => !empty($popups) && is_array($popups),
            'metadata' => $container->getPageMetadata()
        ]);
    }
}