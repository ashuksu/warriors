<?php
namespace Views;

//use Views\Layout\Head;
//use Views\Layout\Header;
//use Views\Layout\Footer;
//use Views\Layout\FooterLinks;
//use Views\Components\Button;
//use Views\Components\Preloader;
//use Views\Components\Popup;;

class Layout {
    public static function render($data = []) {
        extract($data);

//        Head::render([
//            'title' => APP_TITLE ?? 'Warriors',
//            'page' => PAGE
//        ]);

        ?>
        <body data-style="default" class="<?= 'page-' . PAGE ?>">
        <div class="wrapper">
            <?php
//            Preloader::render();
//            Header::render();
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
//            Footer::render();
            ?>
        </div>

        <?php
//        Button::render([
//            'url' => '#content',
//            'class' => 'button--up',
//            'attr' => 'data-element="link" data-action="up"'
//        ]);

//        Popup::render();
//        FooterLinks::render();
        ?>
        </body>
        </html>
        <?php
    }
}