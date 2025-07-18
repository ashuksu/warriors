<section id="<?= $section ?? '' ?>" class="section catalog <?= $section ?? '' ?>">
	<div class="container">
		<div class="inner catalog__inner">
			<h2 class="title mb-3 text-center wow pixFadeUp" data-wow-delay="0.2s">
                <?= $title ?? '' ?>
			</h2>

			<div class="catalog__grid">

                <?php
                if (!empty($collection) && is_array($collection)) {
                    foreach ($collection as $item) {
                        $templateService->render($itemPath ?? __DIR__ . '/item.php', [
                            'item' => $item,
                            'image' => $pathService->getPath('dist/assets/images/items/' . ($item['image'] ?? '')),
                        ]);
                    }
                }
                ?>

			</div>
		</div>
	</div>
</section>