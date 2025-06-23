<?php

namespace App\Views\Sections\Faq;

use App\Core\Container;
use App\Services\TemplateService;
use App\Services\ContentService;
use Exception;

/**
 * Faq section view.
 */
class Faq
{
    /**
     * Renders the Faq section.
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
            'section' => 'faq',
            'collection' => $contentService->get('section', 'faq', 'items'),
            'title' => $contentService->get('section', 'faq', 'title'),
            'templateService' => $templateService
        ]);
    }
}