<?php
$uniqId = ($item['id'] ?? '') . uniqid();
?>

<article id="popup-<?= $item['id'] ?? '' ?>"
		 class="popup popup--<?= $item['id'] ?? '' ?>"
		 data-block="popup"
		 role="dialog"
		 aria-labelledby="popup-title-<?= $uniqId ?>"
		 aria-modal="true"
		 hidden>
	<div class="popup__inner">
		<div class="popup__header">
			<h2 id="popup-title-<?= $uniqId ?>" class="popup__title sub-title">
                <?= $item['title'] ?? '' ?>
			</h2>

            <?php

            use App\Views\Components\Button;

            echo Button::render([
                'class' => 'button--close button--transparent',
                'attr' => 'data-element="popup-close"',
                'aria-label' => 'Close Popup',
                'aria-expanded' => true,
                'aria-controls' => 'popup-' . ($item['id'] ?? ''),
                'role' => 'button'
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
            echo Button::render($button ?? []);
            ?>

		</div>
	</div>
</article>