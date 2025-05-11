<?php
	$setActiveClass = $index === 0 ? 'active' : '';
?>

<div class="faq__item text-justify wow pixFadeUp" data-wow-delay="0.3s">
	<h3 class="sub-title faq__item-title">
		<?= $item['title'] ?>

		<?php
		render_button([
			'url' => 'faq-content-' . $index,
			'class' => 'faq__item-button button--plus button--transparent ' . $setActiveClass,
			'attr' => 'data-button="toggle"',
			'content' => 'Open',
		]);
		?>
	</h3>
	<div id="faq-content-<?= $index ?>" class="faq__item-inner <?= $setActiveClass ?>">
		<div class="faq__item-text">
			<?= $item['text'] ?>
		</div>
	</div>
</div>