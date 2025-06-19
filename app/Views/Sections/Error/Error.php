<?php

namespace App\Views\Sections\Error;

use App\Core\Container;
use App\Services\SectionService;
use Exception;
use function App\Helpers\renderTemplate;

class Error
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
        renderTemplate(__DIR__ . '/template.php', [
            'item' => SectionService::get('error'),
            'section' => 'error',
            'title' => SectionService::get('error', 'title'),
            'metadata' => $container->getPageMetadata()
        ]);
    }
}