<section id="<?= $section ?? '' ?>" class="section contacts <?= $section ?? '' ?>">
	<div class="container">
		<div class="inner">
			<h2 class="title text-center mb-3 wow pixFadeUp" data-wow-delay="0.2s">
                <?= $title ?? '' ?>
			</h2>

			<div class="row contacts__list wow pixFadeUp" data-wow-delay="0.3s">

                <?php
                if (!empty($collection) && is_array($collection)) {
                    foreach ($collection as $item) {
                        $templateService->render($itemPath ?? __DIR__ . '/item.php', [
                            'item' => $item,
                        ]);
                    }
                }
                ?>

			</div>
		</div>
	</div>
</section>