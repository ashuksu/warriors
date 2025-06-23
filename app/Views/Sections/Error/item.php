<p class="error__text error__text wow pixFadeUp" data-wow-delay="0.3s">
    <?= $text ?? '' ?>
</p>
<div class="image error__image mb-3 mx-auto wow pixFadeUp" data-wow-delay="0.4s">

    <?php

    use App\Views\Components\Image;

    echo Image::render([
        'url' => $image ?? '#',
        'alt' => $item['alt'] ?? 'image 404',
        'width' => $item['width'] ?? 600,
        'height' => $item['height'] ?? 600,
        'attr' => 'class="error-image"',
        'noLazy' => true,
        'fetchpriority' => 'high'
    ]);
    ?>

</div>

<?php

use App\Views\Components\Button;

echo Button::render([
    'url' => $button['url'] ?? $configService->get('app_path'),
    'class' => ($button['class'] ?? '') . ' error-button wow pixFadeUp',
    'attr' => ($button['attr'] ?? '') . ' data-wow-delay="0.5s"',
    'content' => $button['content'] ?? 'Back to Home Page',
    'aria-label' => $button['content'] ?? 'Back to Home Page',
    'role' => 'button'
]);
?>