<?php

namespace Views\Sections\Catalog;

use Core\Container;
use Services\SectionService;
use Exception;
use function Helpers\renderTemplate;

class Catalog
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
            'collection' => SectionService::get('catalog', 'items'),
            'section' => 'catalog',
            'title' => SectionService::get('catalog', 'title'),
            'metadata' => $container->getPageMetadata()
        ]);
    }
}