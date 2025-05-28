<section id="<?= $section ?? '' ?>" class="section mt-auto info <?= $section ?? '' ?>">
	<div class="container">
		<div class="inner inner-style text-center info__inner wow pixFadeUp" data-wow-delay="0.2s">
			<h2 class="title">
                <?= $item['title'] ?>
			</h2>
			<div id="<?= $section ?? '' ?>-see-more" class="see-more__content">
				<p class="text-justify">
                    <?= $item['text'] ?>
				</p>
			</div>

            <?php

            use Views\Components\Button;

            echo Button::render([
                'url' => '#' . ($section ?? '') . '-see-more',
                'class' => 'info__button see-more__button button button--up',
                'attr' => 'hidden data-element="toggle" data-action="see-more"',
            ]);
            ?>

		</div>
	</div>
</section>