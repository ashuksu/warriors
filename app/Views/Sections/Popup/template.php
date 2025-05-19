<article id="popup-<?= $item['id'] ?? '' ?>"
         class="popup popup--<?= $item['id'] ?? '' ?>"
         data-block="popup"
         hidden>
    <div class="popup__inner">
        <div class="popup__header">
            <h2 class="popup__title sub-title"><?= $item['title'] ?? '' ?></h2>

            <?php

            use Views\Components\Button;

            echo Button::render([
                'class' => 'button--close button--transparent',
                'attr' => 'data-element="popup-close"',
            ]);
            ?>

        </div>
        <div class="popup__body">
            <div class="popup__content">
                <?= $item['text'] ?? '' ?>
            </div>
        </div>
        <div class="popup__footer">

            <?php
            echo Button::render([
                'url' => $button['url'] ?? '#',
                'attr' => $button['attr'] ?? '',
                'content' => $button['content'] ?? ''
            ]);
            ?>

        </div>
    </div>
</article>