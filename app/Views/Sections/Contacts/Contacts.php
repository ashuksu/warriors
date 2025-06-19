<?php

namespace App\Views\Sections\Contacts;

use App\Core\Container;
use App\Services\SectionService;
use Exception;
use function App\Helpers\renderTemplate;

class Contacts
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
            'collection' => SectionService::get('contacts', 'items'),
            'section' => 'contacts',
            'title' => SectionService::get(PAGE, 'title'),
            'metadata' => $container->getPageMetadata()
        ]);
    }
}