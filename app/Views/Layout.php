<?php

namespace Views;

use Views\Components\Button;
use Views\Components\Popup\Popup;
use Views\Layouts\Footer;
use Views\Layouts\Head;
use Views\Layouts\Header;
use function Helpers\renderTemplate;

class Layout
{
    public static function render($data = [])
    {
        extract($data);

        Head::render([
            'title' => APP_TITLE ?? 'Warriors',
            'page' => PAGE ?? ''
        ]);

        ?>

        <body data-style="default" class="<?= 'page-' . PAGE ?>">
        <div class="wrapper">

            <?php
            renderTemplate(__DIR__ . '/Components/preloader.php', []);

            Header::render();
            ?>

            <main id="content" class="content">

                <?php
                if (!empty($sections) && is_array($sections)) {
                    foreach ($sections as $section) {
                        $sectionClass = 'Views\\Sections\\' . ucfirst($section) . '\\' . ucfirst($section);
                        if (class_exists($sectionClass)) {
                            $sectionClass::render($data);
                        }
                    }
                }
                ?>

            </main>

            <?php
            Footer::render();
            ?>

        </div>

        <?php
        Button::render([
            'url' => '#content',
            'class' => 'button--up',
            'attr' => 'data-element="link" data-action="up"'
        ]);

        Popup::render();

        renderTemplate(__DIR__ . 'Components/footer-links.php', []);
        ?>

        </body>
        </html>

        <?php
    }
}