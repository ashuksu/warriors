<p class="error__text error__text wow pixFadeUp" data-wow-delay="0.3s">
    <?= $text ?? '' ?>
</p>
<div class="image error__image mb-3 mx-auto wow pixFadeUp" data-wow-delay="0.4s">

    <?php

    use Views\Components\Image;

    Image::render([
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

Button::render([
    'url' => $button['url'] ?? '',
    'class' => $button['class'] ?? '',
    'attr' => $button['attr'] ?? '',
    'content' => $button['content'] ?? ''
]);
?>