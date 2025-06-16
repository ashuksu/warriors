<?php

namespace Views\Sections\About;

use Core\Container;
use Services\SectionService;
use Exception;
use function Helpers\renderTemplate;

class About
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
            'collection' => SectionService::get('about', 'items'),
            'section' => 'about',
            'metadata' => $container->getPageMetadata()
        ]);
    }
}