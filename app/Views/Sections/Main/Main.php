<?php

namespace App\Views\Sections\Main;

use App\Core\Container;
use App\Services\TemplateService;
use App\Services\ContentService;
use App\Services\PathService;
use Exception;

/**
 * Main section view.
 */
class Main
{
    /**
     * Renders the Main section.
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

        /** @var PathService $pathService */
        $pathService = $container->get(PathService::class);

        $popups = $contentService->get('section', 'popup', 'items');
        $image = $contentService->get('section','main', 'image');

        $templateService->render(__DIR__ . '/template.php', params: [
            'section' => 'main',
            'item' => $contentService->get('section', 'main'),
            'image' => $contentService->get('section', 'main', 'image'),
            'imagePath' => $pathService->getPath('dist/assets/images/' . ($image['image'] ?? '')),
            'popups' => $popups,
            'isPopups' => !empty($popups) && is_array($popups)
        ]);
    }
}