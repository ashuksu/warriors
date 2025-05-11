<?php
	$isActive = $index === 0 ? 'active' : '';
?>

<div class="faq__item text-justify wow pixFadeUp" data-wow-delay="0.3s">
	<h3 class="sub-title faq__item-title">
		<?= $item['title'] ?>

		<?php
		render_button([
			'url' => 'faq-content-' . $index,
			'class' => 'faq__item-button button--plus button--transparent ' . $isActive,
			'attr' => 'data-button="toggle"',
			'content' => 'Open',
		]);
		?>
	</h3>
	<div id="faq-content-<?= $index ?>" class="faq__item-inner <?= $isActive ?>">
		<div class="faq__item-text">
			<?= $item['text'] ?>
		</div>
	</div>
</div>