<?php

namespace Views\Sections\Error;

use Core\Container;
use Services\SectionService;
use Exception;
use function Helpers\renderTemplate;

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