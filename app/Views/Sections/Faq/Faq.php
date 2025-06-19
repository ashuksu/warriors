<?php

namespace App\Views\Sections\Faq;

use App\Core\Container;
use App\Services\SectionService;
use Exception;
use function App\Helpers\renderTemplate;

class Faq
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
            'collection' => SectionService::get('faq', 'items'),
            'section' => 'faq',
            'title' => SectionService::get('faq', 'title'),
            'metadata' => $container->getPageMetadata()
        ]);

    }
}