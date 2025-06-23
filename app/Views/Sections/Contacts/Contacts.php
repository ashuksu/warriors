<?php

namespace App\Views\Sections\Contacts;

use App\Core\Container;
use App\Services\TemplateService;
use App\Services\ContentService;
use Exception;

/**
 * Contacts section view.
 */
class Contacts
{
    /**
     * Renders the Contacts section.
     *
     * @param Container $container The DI container.
     * @return void
     * @throws Exception
     */
    public static function render(Container $container): void
    {
        /** @var TemplateService $templateService */
        $templateService = $container->get(TemplateService::class);

        /** @var ContentService $contentService */
        $contentService = $container->get(ContentService::class);

        $templateService->render(__DIR__ . '/template.php', params: [
            'section' => 'contacts',
            'collection' => $contentService->get('section', 'contacts', 'items'),
            'title' => $contentService->get('section', 'catalog', 'title'),
            'templateService' => $templateService,
        ]);
    }
}