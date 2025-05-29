<div class="faq__item text-justify wow pixFadeUp" data-wow-delay="0.3s">
	<h3 class="sub-title faq__item-title">
        <?= $item['title'] ?? '' ?>

        <?php

        use Views\Components\Button;

        echo Button::render([
            'url' => '#faq-content-' . $index ?? '',
            'class' => 'faq__item-button button--plus button--transparent ' . $setActiveClass ?? '',
            'attr' => 'data-element="toggle"',
            'content' => '<span class="visually-hidden">Toggle answer</span>',
            'aria-expanded' => $index === 0 ? 'true' : 'false',
            'aria-controls' => 'faq-content-' . $index,
            'role' => 'button'
        ]);
        ?>

	</h3>
	<div id="faq-content-<?= $index ?? '' ?>"
		 class="faq__item-inner <?= $setActiveClass ?? '' ?>"
		 role="region"
		 aria-labelledby="faq-heading-<?= $index ?>">
		<div class="faq__item-text">
            <?= $item['text'] ?? '' ?>
		</div>
	</div>
</div>