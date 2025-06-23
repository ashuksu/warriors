<?php

namespace App\Views\Sections\Catalog;

use App\Core\Container;
use App\Services\TemplateService;
use App\Services\ContentService;
use App\Services\ViteService;
use Exception;

/**
 * Catalog section view.
 */
class Catalog
{
    /**
     * Renders the Catalog section.
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
            'section' => 'catalog',
            'collection' => $contentService->get('section', 'catalog', 'items'),
            'title' => $contentService->get('section', 'catalog', 'title'),
            'templateService' => $templateService,
            'viteService' => $viteService
        ]);
    }
}