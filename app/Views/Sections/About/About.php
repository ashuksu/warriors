<?php

namespace App\Views\Sections\About;

use App\Core\Container;
use App\Services\SectionService;
use Exception;
use function App\Helpers\renderTemplate;

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