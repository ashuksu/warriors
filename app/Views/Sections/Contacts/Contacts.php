<?php

namespace Views\Sections\Contacts;

use Core\Container;
use Services\SectionService;
use Exception;
use function Helpers\renderTemplate;

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