<?php

namespace Views\Sections;

use Helpers\Device;
use Services\SectionService;
use Views\Components\Button;

/**
 * Menu section class
 *
 * Handles rendering of the site navigation menu with links and popup button
 */
class Menu
{
    /**
     * Render the menu section
     *
     * Outputs the navigation menu with close button, menu links, and popup button
     *
     * @param array $params Parameters for the menu section
     * @return void
     */
    public static function render($params = [])
    {
        extract($params);

        $popup = SectionService::get('popup', 'items', 'p002');
        $menu = SectionService::get('menu', 'items');
        ?>

		<nav id="menu" class="menu" data-block="menu" role="navigation" aria-label="Main Menu">

            <?php
            echo Button::render([
                'class' => 'button--close button--transparent',
                'attr' => 'data-element="menu-close"' . (Device::isDesktop() ? ' hidden' : ''),
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
                        $url = APP_PATH . $hash . $id;
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
            echo Button::render([
                'url' => '#popup-' . ($popup['id'] ?? ''),
                'attr' => 'data-element="popup-open"' . (Device::isDesktop() ? ' hidden' : ''),
                'content' => 'Open ' . ($popup['name'] ?? ''),
                'aria-label' => 'Open ' . ($popup['name'] ?? '') . ' Popup',
                'aria-expanded' => false,
                'aria-controls' => 'popup-' . ($popup['id'] ?? ''),
                'role' => 'button'
            ]);
            ?>

		</nav>
        <?php
    }
}