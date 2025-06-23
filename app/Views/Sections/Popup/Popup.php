<?php

namespace App\Views\Sections\Popup;

use App\Core\Container;
use App\Services\ContentService;
use App\Services\TemplateService;
use Exception;

/**
 * Popup section view.
 */
class Popup
{
    /**
     * Renders the Popup section.
     *
     * @param Container $container The DI container.
     * @return void
     * @throws Exception
     */
    public static function render(Container $container): void
    {
        /** @var ContentService $contentService */
        $contentService = $container->get(ContentService::class);

        /** @var TemplateService $templateService */
        $templateService = $container->get(TemplateService::class);

        $popups = $contentService->get('section', 'popup', 'items');

        if (!empty($popups) && is_array($popups)) {
            foreach ($popups as $itemPopup) {
                $templateService->render(__DIR__ . '/template.php', params: [
                    'item' => $itemPopup,
                    'button' => $itemPopup['button'],
                    'container' => $container,
                    'templateService' => $templateService
                ]);
            }
        }
    }
}