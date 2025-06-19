<?php

namespace App\Views\Sections\Info;

use App\Core\Container;
use App\Services\SectionService;
use Exception;
use function App\Helpers\renderTemplate;

class Info
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
        renderTemplate(__DIR__ . '/template.php', params: [
            'item' => SectionService::get('info', 'items', 'info-' . PAGE),
            'section' => 'info',
            'metadata' => $container->getPageMetadata()
        ]);
    }
}