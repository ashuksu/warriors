<section id="<?= $section ?? '' ?>" class="section error <?= $section ?? '' ?>">
	<div class="container">
		<div class="inner error__inner text-center mx-auto">
			<h2 class="title mb-3 wow pixFadeUp" data-wow-delay="0.2s">
                <?= $title ?? '' ?>
			</h2>

            <?php
            if (!empty($item) && is_array($item)) {
                $templateService->render($itemPath ?? __DIR__ . '/item.php', [
                    'text' => $item['text'] ?? '',
                    'image' => $pathService->getPath('dist/assets/images/' . ($item['image']['image'] ?? '')),
                    'item' => $item['image'] ?? '',
                    'button' => $item['button'] ?? '',
                    'configService' => $configService
                ]);
            }
            ?>

		</div>
	</div>
</section>