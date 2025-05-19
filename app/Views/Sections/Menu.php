<?php

namespace Views\Sections;

use Services\SectionService;
use Views\Components\Button;

class Menu
{
    public static function render($params = [])
    {
        extract($params);

        $popup = SectionService::get('popup', 'items', 'p002');
        $menu = SectionService::get('menu', 'items');
        ?>

        <nav id="menu" class="menu" data-block="menu">

            <?php
            echo Button::render([
                'class' => 'button--close button--transparent',
                'attr' => 'data-element="menu-close"'
            ]);
            ?>

            <div class="menu__list">
                <?php
                if (!empty($menu) && is_array($menu)) {
                    foreach ($menu as $item) {
                        $hash = $item['hash'] ?? '';
                        $id = $item['id'] ?? '';
                        $name = $item['name'] ?? '';
                        $url = APP_PATH . $hash . $id;
                        ?>

                        <a href="<?= $url ?>" class="menu__link link" data-element="link">
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
                'attr' => 'data-element="popup-open"',
                'content' => 'Open ' . ($popup['name'] ?? ''),
            ]);
            ?>

        </nav>
        <?php
    }
}
