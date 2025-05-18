<?php

namespace Views\Components\Menu;

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
            Button::render([
                'class' => 'button button--close button--transparent',
                'attr' => 'data-element="menu-close"'
            ]);

            ?>

            <?php if (!empty($menu) && is_array($menu)): ?>
                <div class="menu__list">

                    <?php foreach ($menu as $item): ?>

                        <a class="menu__link link" data-element="link"
                           href="<?= APP_PATH . $item['hash'] . $item['id'] ?>"><?= $item['name'] ?></a>

                    <?php endforeach; ?>

                </div>
            <?php endif; ?>

            <?php
            if (!empty($popup) && is_array($popup)) {
                Button::render([
                    'url' => '#popup-' . $popup['id'],
                    'attr' => 'data-element="popup-open"',
                    'content' => 'Open ' . $popup['name'],
                ]);
            }
            ?>

        </nav>
        <?php
    }
}
