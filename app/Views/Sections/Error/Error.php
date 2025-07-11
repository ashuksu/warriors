<?php

namespace App\Views\Sections\Error;

use App\Core\Container;
use App\Services\ConfigService;
use App\Services\TemplateService;
use App\Services\ContentService;
use App\Services\PathService;
use Exception;

/**
 * Error section view.
 */
class Error
{
    /**
     * Renders the Error section.
     *
     * @param Container $container The DI container.
     * @return void
     * @throws Exception
     */
    public static function render(Container $container): void
    {
        /** @var ConfigService $configService */
        $configService = $container->get(ConfigService::class);

        /** @var TemplateService $templateService */
        $templateService = $container->get(TemplateService::class);

        /** @var ContentService $contentService */
        $contentService = $container->get(ContentService::class);

        /** @var PathService $pathService */
        $pathService = $container->get(PathService::class);

        $templateService->render(__DIR__ . '/template.php', params: [
            'section' => 'error',
            'item' => $contentService->get('section', 'error'),
            'title' => $contentService->get('section', 'error', 'title'),
            'templateService' => $templateService,
            'pathService' => $pathService,
            'configService' => $configService
        ]);
    }
}