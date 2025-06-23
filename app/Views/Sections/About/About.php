<?php

namespace App\Views\Sections\About;

use App\Core\Container;
use App\Services\TemplateService;
use App\Services\ContentService;
use App\Services\ViteService;
use Exception;

/**
 * About section view.
 */
class About
{
    /**
     * Renders the About section.
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

        /** @var ViteService $viteService */
        $viteService = $container->get(ViteService::class);

        $templateService->render(__DIR__ . '/template.php', params: [
            'section' => 'about',
            'collection' => $contentService->get('section', 'about', 'items'),
            'templateService' => $templateService,
            'viteService' => $viteService
        ]);
    }
}