<p class="error__text error__text wow pixFadeUp" data-wow-delay="0.3s">
    <?= $text ?? '' ?>
</p>
<div class="image error__image mb-3 mx-auto wow pixFadeUp" data-wow-delay="0.4s">

    <?php

    use Views\Components\Image;

    echo Image::render([
        'url' => $image,
        'alt' => $item['alt'],
        'width' => $item['width'],
        'height' => $item['height'],
        'attr' => 'class="error-image"'
    ]);
    ?>

</div>

<?php

use Views\Components\Button;

echo Button::render([
    'url' => $button['url'] ?? APP_PATH,
    'class' => ($button['class'] ?? '') . ' error-button wow pixFadeUp',
    'attr' => ($button['attr'] ?? '') . ' data-wow-delay="0.5s"',
    'content' => $button['content'] ?? 'Back to Homepage',
    'aria-label' => $button['content'] ?? 'Back to Homepage',
    'role' => 'button'
]);
?>