<?php

namespace App\Views\Sections\Info;

use App\Core\Container;
use App\Services\TemplateService;
use App\Services\ContentService;
use Exception;

/**
 * Info section view.
 */
class Info
{
    /**
     * Renders the Info section.
     *
     * @param Container $container The DI container.
     * @return void
     * @throws Exception
     */
    public static function render(Container $container): void
    {
        $pageData = $container->getPageData();

        /** @var TemplateService $templateService */
        $templateService = $container->get(TemplateService::class);

        /** @var ContentService $contentService */
        $contentService = $container->get(ContentService::class);

        $templateService->render(__DIR__ . '/template.php', params: [
            'section' => 'info',
            'item' => $contentService->get('section', 'info', 'items', 'info-' . $pageData['name'] ?? 'home')
        ]);
    }
}