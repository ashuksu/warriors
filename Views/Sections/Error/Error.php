<?php

namespace Views\Sections\Error;

use Views\Components\Button;

class Error
{
    public static function render($params = [])
    {
        extract($params);
        ?>

        <section class="section error">
            <div class="container">
                <div class="inner error__inner text-center">
                    <h1 class="title mb-3 wow pixFadeUp" data-wow-delay="0.2s">
                        <?= $title ?>
                    </h1>
                    <p class="error__text error__text wow pixFadeUp" data-wow-delay="0.3s">
                        <?= $text ?>
                    </p>
                    <div class="image error__image mb-3 mx-auto wow pixFadeUp" data-wow-delay="0.4s">
                        <img src="<?= APP_PATH ?>public/assets/images/<?= $image['name'] ?>" alt="<?= $image['alt'] ?>"
                             class="error-image" width="<?= $image['width'] ?>" height="<?= $image['height'] ?>">
                    </div>

                    <?php
                    Button::render([
                        'url' => $button['url'],
                        'class' => $button['class'],
                        'attr' => $button['attr'],
                        'content' => $button['content']
                    ]);
                    ?>

                </div>
            </div>
        </section>
        <?php
    }
}