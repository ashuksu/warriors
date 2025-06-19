<section id="<?= $section ?? '' ?>" class="section main <?= $section ?? '' ?>">
	<div class="container">
		<div class="row">
			<div class="col col-lg-5 col-md-6 mb-1 mb-md-0">
				<div class="inner main__inner">
					<h2 class="title main__title">
                        <?= $item['title'] ?? '' ?>
					</h2>
					<p class="main__text">
                        <?= $item['text'] ?? '' ?>
					</p>

                    <?php

                    use App\Views\Components\Button;

                    if ($isPopups) {
                        foreach ($popups as $item) {
                            echo Button::render([
                                'url' => '#popup-' . ($item['id'] ?? ''),
                                'attr' => 'data-element="popup-open"',
                                'content' => 'Open popup ' . ($item['name'] ?? 'Dialog'),
                                'aria-label' => 'Open popup ' . ($item['name'] ?? 'Dialog'),
                                'aria-expanded' => false,
                                'aria-controls' => 'popup-' . ($item['id'] ?? ''),
                                'role' => 'button'
                            ]);
                        }
                    }
                    ?>

				</div>
			</div>
			<div class="col col-md-6">
				<div class="image">

                    <?php

                    use App\Views\Components\Image;

                    echo Image::render([
                        'url' => $imagePath ?? '#',
                        'alt' => $image['alt'] ?? 'main-section image',
                        'width' => $image['width'] ?? 600,
                        'height' => $image['height'] ?? 600,
                        'noLazy' => true,
                        'fetchpriority' => 'high'
                    ]);
                    ?>

				</div>
			</div>
		</div>
	</div>
</section>
