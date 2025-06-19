<?php

namespace App\Views\Sections\Catalog;

use App\Core\Container;
use App\Services\SectionService;
use Exception;
use function App\Helpers\renderTemplate;

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