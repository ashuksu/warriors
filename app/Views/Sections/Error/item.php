<p class="error__text error__text wow pixFadeUp" data-wow-delay="0.3s">
    <?= $text ?? '' ?>
</p>
<div class="image error__image mb-3 mx-auto wow pixFadeUp" data-wow-delay="0.4s">
    <img src="<?= $image ?? '#' ?>" alt="<?= $item['alt'] ?? '' ?>"
         class="error-image" width="<?= $item['width'] ?? 600 ?>" height="<?= $item['height'] ?? 600 ?>">
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