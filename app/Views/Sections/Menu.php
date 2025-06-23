<?php

namespace App\Views\Sections;

use App\Core\Container;
use App\Services\ConfigService;
use App\Services\ContentService;
use App\Services\DeviceService;
use App\Views\Components\Button;
use Exception;

/**
 * Menu section view.
 */
class Menu
{
    /**
     * Renders the Menu section.
     *
     * @param Container $container The DI container.
     * @return void
     * @throws Exception
     */
    public static function render(Container $container): void
    {
       /** @var ConfigService $configService */
        $configService = $container->get(ConfigService::class);

        /** @var ContentService $contentService */
        $contentService = $container->get(ContentService::class);

        /** @var DeviceService $deviceService */
        $deviceService = $container->get(DeviceService::class);

        $popup = $contentService->get('section', 'popup', 'items', 'p002');
        $menu = $contentService->get('section', 'menu', 'items');
        ?>

		<nav id="menu" class="menu" data-block="menu" role="navigation" aria-label="Main Menu">

            <?php
            echo Button::render([
                'class' => 'button--close button--transparent',
                'attr' => 'data-element="menu-close"' . ($deviceService->isDesktop() ? ' hidden' : ''),
                'aria-label' => 'Close Main Menu',
                'aria-expanded' => true,
                'aria-controls' => 'menu',
                'role' => 'button'
            ]);
            ?>

			<div class="menu__list" role="menubar">
                <?php
                if (!empty($menu) && is_array($menu)) {
                    foreach ($menu as $item) {
                        $hash = $item['hash'] ?? '';
                        $id = $item['id'] ?? '';
                        $name = $item['name'] ?? '';
                        $url = $configService->get('app_path') . $hash . $id;
                        ?>

						<a href="<?= $url ?>"
						   class="menu__link link"
						   data-element="link"
						   role="menuitem">
                            <?= $name ?? '' ?>
						</a>

                        <?php
                    }
                }
                ?>
			</div>

            <?php
			if ($popup) {
				echo Button::render([
					'url' => '#popup-' . ($popup['id'] ?? ''),
					'attr' => 'data-element="popup-open"' . ($deviceService->isDesktop() ? ' hidden' : ''),
					'content' => 'Open ' . ($popup['name'] ?? ''),
					'aria-label' => 'Open ' . ($popup['name'] ?? '') . ' Popup',
					'aria-expanded' => false,
					'aria-controls' => 'popup-' . ($popup['id'] ?? ''),
					'role' => 'button'
				]);
			}
            ?>

		</nav>
        <?php
    }
}