<?php

use Views\Components\Button;

?>

<article class="popup popup--<?= $item['id'] ?>" id="popup-<?= $item['id'] ?>" data-block="popup" hidden>
    <div class="popup__inner">
        <div class="popup__header">
            <h2 class="popup__title sub-title"><?= $item['title'] ?></h2>

            <?php
            Button::render([
                'class' => 'button button--close button--transparent',
                'attr' => 'data-element="popup-close"',
            ]);
            ?>

        </div>
        <div class="popup__body">
            <div class="popup__content">
                <?= $item['text'] ?>
            </div>
        </div>
        <div class="popup__footer">
            <?= $item['button'] ?>
        </div>
    </div>
</article>